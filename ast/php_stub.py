import cStringIO as StringIO

from casing import title

class Printer(object):
  def __init__(self):
    self._type_name = None
    # Map concrete type to base class
    self._bases = {}

    self._fields = []

    self._file = StringIO.StringIO()

  def start_file(self):
    return True

  def end_file(self):
    print >> self._file

  def _base_class(self, type):
    return self._bases.get(type, 'Node')

  def start_type(self, name):
    self._type_name = name
    base = self._base_class(name)
    print >> self._file, '''<?php

namespace Facebook\GraphQL\AST;
'''
    print >> self._file, 'class %s extends %s' % (name, base)
    print >> self._file, '{'
    self._fields = []

  def field(self, type, name, nullable, plural):
    if type == 'OperationKind':
      type = 'string'
    self._fields.append((type, name, nullable, plural))

  def end_type(self, name):
    self.print_fields()
    self.print_constructor()
    print >> self._file, ''
    self.print_getters()
    # print >> self._file, '  public function accept(AstVisitor $visitor);'
    print >> self._file, '}'
    print >> self._file, ''
    print >> self._file, ''
    
    self.write_to_file()

    self._type_name = None
    self._fields = []

  def _storage_type(self, type):
    if type == 'string':
      return 'string'
    elif type == 'boolean':
      return 'bool'
    else:
      return type

  def print_fields(self):
    for (type, name, nullable, plural) in self._fields:
      storage_type = self._storage_type(type)
      if plural:
        storage_type = storage_type + '[]'
      print >> self._file, '  /**'
      print >> self._file, '   * @var %s' % (storage_type)
      print >> self._file, '   */'
      print >> self._file, '  private $%s;' % (name)
      print >> self._file, ''

  def _ctor_singular_type(self, type):
    if type == 'string':
      return 'string'
    elif type == 'boolean':
      return 'bool'
    else:
      return '%s' % type

  def _ctor_plural_type(self, type):
    # return '%s[]' % self._storage_type(type)
    return 'array'

  def print_constructor(self):
    print >> self._file, '  public function __construct('
    print >> self._file, '      Location $location%s' % (',' if self._fields else '')
    def ctor_arg(type, name, plural):
      if plural:
        ctor_type = self._ctor_plural_type(type)
      else:
        ctor_type = self._ctor_singular_type(type)
      return '      %s $%s' % (ctor_type, name)
    if self._fields:
      print >> self._file, ',\n'.join(ctor_arg(type, name, plural)
                     for (type, name, nullable, plural) in self._fields)
    print >> self._file, '  )'
    def ctor_init(type, name, plural):
      # Strings are const char *, just pass.
      # Vectors are passed by pointer and we take ownership.
      # Node types are passed in by pointer and we take ownership.
      value = name
      return '      $this->%s = $%s;' % (name, value)
    print >> self._file, '  {'
    print >> self._file, '      $this->location = $location;'
    if self._fields:
      print >> self._file, '\n'.join(ctor_init(type, name, plural)
                     for (type, name, nullable, plural)
                     in self._fields)
    print >> self._file, '  }'

  def _getter_type(self, type, nullable, plural):
    if plural and nullable:
      return '?array // %s[]' % self._storage_type(type)
    elif plural:
      return 'array // %s[]' %  self._storage_type(type)

    if type == 'string':
      assert not nullable
      return 'string'
    elif type == 'boolean':
      assert not nullable
      return 'bool'
    elif nullable:
      return '?%s' % type
    else:
      return '%s' % type

  def _getter_value_to_return(self, raw_value, type, nullable, plural):
    return '$this->' + raw_value

  def print_getters(self):
    for idx, (type, name, nullable, plural) in enumerate(self._fields):
      print >> self._file, '  public function get%s(): %s' % (
        title(name),
        self._getter_type(type, nullable, plural))
      print >> self._file, '  {'
      print >> self._file, '    return %s;' % (
        self._getter_value_to_return(name, type, nullable, plural))
      print >> self._file, '  }'
      if idx != len(self._fields) - 1:
        print >> self._file, ''
  
  def start_union(self, name):
    print >> self._file, '''<?php

namespace Facebook\GraphQL\AST;
'''

    self._type_name = name
    # non-deferred!
    print >> self._file, 'class %s extends Node' % name
    print >> self._file, '{'
    self.print_constructor()
    print >> self._file, '}'
    print >> self._file, ''

  def union_option(self, type):
    assert type not in self._bases, '%s cannot appear in more than one union!' % type
    self._bases[type] = self._type_name

  def end_union(self, name):
    self.write_to_file()
    pass

  def write_to_file(self):
    if self._type_name:
      file = open('php/' + self._type_name + '.php', 'w')
      file.write(self._file.getvalue())
      self._file = StringIO.StringIO()
