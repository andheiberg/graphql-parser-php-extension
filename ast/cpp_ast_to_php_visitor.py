import cStringIO as StringIO

class Printer(object):
  def __init__(self):
    # These types are "aliases" of other types added to simplify the code
    # Basically if we had 1 values bag we would be required to write logic
    # To split defaultValues from the values bag.
    self._types = [
      'DefaultValue',
      'Alias',
      'TypeCondition',
      'OperationType',
      'Interface',
      'Location'
    ]
    # Map concrete type to base class
    self._bases = {}
    self._fields = []
    self._defOut = StringIO.StringIO()

  def start_file(self):
    pass

  def end_file(self):
    print """/** @generated */

#include <graphqlparser/AstVisitor.h>
#include <graphqlparser/Ast.h>
#include <phpcpp.h>
#include "../src/Node.cpp"
#include "ast.cpp"

class ASTToPHPVisitor : public facebook::graphql::ast::visitor::AstVisitor {
private:
  %s

  Php::Value getLocation(const facebook::graphql::ast::Node &node) {
    return Php::Object(
      "AndHeiberg\\\\GraphQL\\\\Parser\\\\AST\\\\Location",
      Php::Object(
        "AndHeiberg\\\\GraphQL\\\\Parser\\\\AST\\\\Position",
        node.getLocation().begin.filename,
        (int) node.getLocation().begin.line,
        (int) node.getLocation().begin.column
      ),
      Php::Object(
        "AndHeiberg\\\\GraphQL\\\\Parser\\\\AST\\\\Position",
        node.getLocation().end.filename,
        (int) node.getLocation().end.line,
        (int) node.getLocation().end.column
      )
    );
  }
""" % ("\n  ").join(
    "Php::Array _%ss;" % (self.lowerFirst(type)) for type in self._types
  )
    print self._defOut.getvalue()
    print """public:
  ASTToPHPVisitor() = default;
  ~ASTToPHPVisitor() = default;

  Php::Value getResult() const {
    return _documents[0]; 
  }
};
"""

  def start_type(self, name):
    self._types.append(name)
    self._fields = []

  def field(self, type, name, nullable, plural):
    if type == 'OperationKind':
      type = 'string'
    
    self._fields.append((type, name, nullable, plural))

  def _print_field(self, type, fieldName, nullable, plural):
    bucket = self._bases.get(fieldName, fieldName)

    if type in ['string', 'boolean']:
        return "node.get%s()" % (self.upperFirst(fieldName))
    if not plural:
      return "_%ss.contains(0) ? _%ss[0] : Php::Value()" % (bucket, bucket)
    else:
      return "_%s" % (bucket)

  def _reset_field(self, type, fieldName, nullable, plural):
    bucket = self._bases.get(fieldName, fieldName)

    if type in ['string', 'boolean']:
        return ""
    if not plural:
      return "_%ss = Php::Array();" % (bucket)
    else:
      return "_%s = Php::Array();" % (bucket)

  def end_type(self, name):
    print >> self._defOut, """  bool visit%(tn)s(const facebook::graphql::ast::%(tn)s &node) {
    return true;
  }

  void endVisit%(tn)s(const facebook::graphql::ast::%(tn)s &node) {
    _%(bucket)ss[_%(bucket)ss.count()] = Php::Object(
      "AndHeiberg\\\\GraphQL\\\\Parser\\\\AST\\\\%(tn)s",
      getLocation(node)%(fcomma)s%(fields)s
    );

    %(reset)s
  }
""" % {
      'n': self.lowerFirst(name),
      'tn': name,
      'bucket': self.lowerFirst(self._bases.get(name, name)),
      'fcomma': ",\n      " if self._fields else '',
      'fields': ",\n      ".join(
        self._print_field(type, fieldName, nullable, plural)
        for type, fieldName, nullable, plural in self._fields
      ),
      'reset': "\n    ".join(
        self._reset_field(type, fieldName, nullable, plural)
        for type, fieldName, nullable, plural in self._fields
      )
    }

  def start_union(self, name):
    self._type_name = name
    self._types.append(name)

  def union_option(self, type):
    assert type not in self._bases, '%s cannot appear in more than one union!' % type
    self._bases[type] = self._type_name

  def end_union(self, name):
    pass

  def lowerFirst(self, s):
    return s[:1].lower() + s[1:] if s else ''

  def upperFirst(self, s):
    return s[:1].upper() + s[1:] if s else ''