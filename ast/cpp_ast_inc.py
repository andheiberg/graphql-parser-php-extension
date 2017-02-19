# File that generates the ast.php.inc file which is the PHP extensions representation of the PHP classes

import cStringIO as StringIO

class Printer(object):
  def __init__(self):
    self._type_name = None
    # Map concrete type to base class
    self._bases = {}
    self._fields = []

  def start_file(self):
    print "/** @generated */\n"

  def end_file(self):
    pass

  def start_type(self, name):
    self._type_name = name
    self._fields = []

  def field(self, type, name, nullable, plural):
    if type == 'OperationKind':
      type = 'string'

    self._fields.append((type, name, nullable, plural))

  def end_type(self, name):
    print "// %s PHP class" % (name)
    print 'Php::Class<%s> %s("AndHeiberg\\\\GraphQL\\\\Parser\\\\AST\\\\%s");' % (name, self.lowerFirst(name), name)
    print
    self._print_constructor()
    print
    self._print_getters()
    print
    print 'extension.add(std::move(%s));' % (self.lowerFirst(name))
    print
    self._type_name = None
    self._fields = []

  def _print_constructor(self):
    fields_str = ''
    
    if len(self._fields):
      fields_str += ', {'

    for (type, name, nullable, plural) in self._fields:
        fields_str += '\n  Php::ByVal("%s", %s),' % (name, self._get_byval_type(type))

    if len(self._fields):
      fields_str += '\n}'

    print '%s.method<&%s::__construct> ("__construct"%s);' % (self.lowerFirst(self._type_name), self._type_name, fields_str)

  def _print_getters(self):
    print '\n'.join(
      '%s.method<&%s::get%s> ("get%s");' % (self.lowerFirst(self._type_name), self._type_name, self.upperFirst(name), self.upperFirst(name))
      for type, name, nullable, plural in self._fields
    )

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
    print "// %s PHP class" % (name)
    print 'Php::Class<%s> %s("AndHeiberg\\\\GraphQL\\\\Parser\\\\AST\\\\%s");' % (name, self.lowerFirst(name), name)
    print
    print 'extension.add(std::move(%s));' % (self.lowerFirst(name))
    print

  def lowerFirst(self, s):
    return s[:1].lower() + s[1:] if s else ''

  def upperFirst(self, s):
    return s[:1].upper() + s[1:] if s else ''
