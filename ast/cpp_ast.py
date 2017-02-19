# File that generates the ast.cpp file which is the PHP extensions representation of the PHP classes

import cStringIO as StringIO

class Printer(object):
  def __init__(self):
    self._type_name = None
    # Map concrete type to base class
    self._bases = {}
    # HACK: Defer everything we print so that forward declarations for
    # all classes come first. Avoids having to do 2 passes over the
    # input file.
    self._defOut = StringIO.StringIO()

    self._fields = []

  def start_file(self):
    print '''/** @generated */

#pragma once

#include "../src/Node.cpp"
'''

  def end_file(self):
    print self._defOut.getvalue()

  def _base_class(self, type):
    return self._bases.get(type, 'Node')

  def start_type(self, name):
    self._type_name = name
    base = self._base_class(name)
    # non-deferred!
    print 'class %s;' % name
    print >> self._defOut, 'class %s : public %s {' % (name, base)
    self._fields = []

  def field(self, type, name, nullable, plural):
    if type == 'OperationKind':
      type = 'string'
    self._fields.append((type, name, nullable, plural))

  def end_type(self, name):
    self._print_fields()
    print >> self._defOut, ' public:'
    self._print_con_n_destructor()
    print >> self._defOut
    self._print_getters()
    # print >> self._defOut, '  void accept(visitor::AstVisitor *visitor) override;'
    print >> self._defOut, '};'
    print >> self._defOut
    self._type_name = None
    self._fields = []

  def _print_fields(self):
    print >> self._defOut, ' private:'
    for (type, name, nullable, plural) in self._fields:
      storage_type = 'Php::Value'
      if plural:
        storage_type = 'Php::Array'
      print >> self._defOut, '  %s _%s;' % (storage_type, name)

  def _print_con_n_destructor(self):
    # C++ constructor and deconstructor
    print >> self._defOut, '  %s() = default;' % self._type_name
    print >> self._defOut, '  virtual ~%s() = default;' % self._type_name
    print >> self._defOut

    # PHP __construct
    print >> self._defOut, '  void __construct(Php::Parameters &params)'
    print >> self._defOut, '  {'
    print >> self._defOut, '    setLocation(params[0]);'

    print >> self._defOut, '\n'.join(
      "    if (params[%i]) {\n      _%s = params[%i];\n    }" % (idx + 1, name, idx + 1) if nullable else '    _%s = params[%i];' % (name, idx + 1)
      for idx, (type, name, nullable, plural) in enumerate(self._fields)
    )

    print >> self._defOut, '  }'

  def _print_getters(self):
    for (type, name, nullable, plural) in self._fields:
      print >> self._defOut, '  Php::Value get%s() const' % (self.upperFirst(name))
      print >> self._defOut, '  {'
      print >> self._defOut, '    return %s;' % ('_' + name)
      print >> self._defOut, '  }'
      print >> self._defOut

  def start_union(self, name):
    self._type_name = name
    # non-deferred!
    print 'class %s;' % name

    print >> self._defOut, 'class %s : public Node {' % name
    print >> self._defOut, ' public:'
    # used to only have constructor
    self._print_con_n_destructor()
    print >> self._defOut, '};'
    print >> self._defOut

  def union_option(self, type):
    assert type not in self._bases, '%s cannot appear in more than one union!' % type
    self._bases[type] = self._type_name

  def end_union(self, name):
    pass

  def upperFirst(self, s):
    return s[:1].upper() + s[1:] if s else ''
