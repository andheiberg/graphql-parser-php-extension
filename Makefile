# Name of the PHP extension
NAME				=	graphql-parser
# Location of your PHP installations configured con.d directory
INI_DIR				=	/usr/local/etc/php/7.1/conf.d
# Location of your PHP installations configured extension directory
EXTENSION_DIR		=	$(shell php-config --extension-dir)

EXTENSION 			=	${NAME}.so
INI 				=	${NAME}.ini

COMPILER			=	g++
LINKER				=	g++

# Compiler flag -O2 enables code optimization. For debugging remove and add -g
COMPILER_FLAGS		=	-Wall -c -O2 -std=c++11 -fpic -o
LINKER_FLAGS		=	-shared -undefined dynamic_lookup
# If your extension depends on other libraries, you should update this with a list
# of all flags that should be passed to the linker.
LINKER_DEPENDENCIES	=	-lphpcpp

#
#	All source files are simply all *.cpp files found in the current directory
#
#	A builtin Makefile macro is used to scan the current directory and find 
#	all source files. The object files are all compiled versions of the source
#	file, with the .cpp extension being replaced by .o.
#

SOURCES				=	$(wildcard src/*.cpp)
OBJECTS				=	$(SOURCES:%.cpp=%.o)

AST 				= ast/ast.ast
AST_SOURCE 			= https://raw.githubusercontent.com/graphql/libgraphqlparser/master/ast/ast.ast
AST_PHP             = $(wildcard ast/php/*.cpp)
AST_PHP_STUBS       = $(wildcard ast/php_stubs/*.php)

all: ${EXTENSION}

${EXTENSION}: ${OBJECTS}
	${LINKER} ${LINKER_FLAGS} -o $@ ${OBJECTS} ${LINKER_DEPENDENCIES}

${OBJECTS}:
	${COMPILER} ${COMPILER_FLAGS} $@ ${@:%.o=%.cpp}

ast.ast:
	if [ ! -f ${AST} ]; then wget -O ${AST} ${AST_SOURCE}; fi
	# cd ast && python ast.py php ast.ast
	cd ast && python ast.py php_ast_stubs ast.ast

install:		
	cp -f ${EXTENSION} ${EXTENSION_DIR}
	cp -f ${INI} ${INI_DIR}
				
clean:
	rm -f ${EXTENSION} ${OBJECTS}
	rm -f ${AST} ${AST_PHP_STUBS}

