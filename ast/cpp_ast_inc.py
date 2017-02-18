# File that generates the ast.php.inc file which is the PHP extensions representation of the PHP classes

import cStringIO as StringIO

class Printer(object):
  def __init__(self):
    self._type_name = None
    # Map concrete type to base class
    self._bases = {}
    self._out = StringIO.StringIO()

    self._fields = []

  def start_file(self):
    print >> self._out, "/** @generated */\n"

  def end_file(self):
    file = open('generated/ast.php.inc', 'w')
    file.write(self._out.getvalue())

  def start_type(self, name):
    self._type_name = name
    self._fields = []

  def field(self, type, name, nullable, plural):
    if type == 'OperationKind':
      type = 'string'
    self._fields.append((type, name, nullable, plural))

  def end_type(self, name):
    print >> self._out, "// %s PHP class" % (name)
    print >> self._out, 'Php::Class<%s> %s("AndHeiberg\\\\GraphQL\\\\Parser\\\\AST\\\\%s");' % (name, name, name)
    print >> self._out
    self._print_getters()
    print >> self._out
    print >> self._out, 'extension.add(std::move(%s));' % (name)
    print >> self._out
    self._type_name = None
    self._fields = []

  def _getter_type(self, type, nullable, plural):
    if plural:
      return 'Php::Array'

    return 'Php::Value'

  def _print_getters(self):
    fields_str = ''
    
    if len(self._fields):
      fields_str += ', {'

    for (type, name, nullable, plural) in self._fields:
        fields_str += '\n  Php::ByVal("%s", %s),' % (name, self._get_byval_type(type))

    if len(self._fields):
      fields_str += '\n}'

    print >> self._out, '%s.method<&%s::__construct> ("__construct"%s);' % (self._type_name, self._type_name, fields_str)

  def _get_byval_type(self, type):
    if type == 'string':
      return 'Php::Type::String'

    if type == 'boolean':
      return 'Php::Type::Bool'

    return '"AndHeiberg\\\\GraphQL\\\\Parser\\\\AST\\\\%s"' % type

  def start_union(self, name):
    self._type_name = name
    self._fields = []

  def union_option(self, type):
    assert type not in self._bases, '%s cannot appear in more than one union!' % type
    self._bases[type] = self._type_name

  def end_union(self, name):
    print >> self._out, "// %s PHP class" % (name)
    print >> self._out, 'Php::Class<%s> %s("AndHeiberg\\\\GraphQL\\\\Parser\\\\AST\\\\%s");' % (name, name, name)
    print >> self._out
    print >> self._out, 'extension.add(std::move(%s));' % (name)
    print >> self._out
