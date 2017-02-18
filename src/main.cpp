#include <phpcpp.h>
#include "Parser.cpp"
#include "Node.cpp"
#include "../generated/ast.cpp"

/**
 *  tell the compiler that the get_module is a pure C function
 */
extern "C" {

    /**
     *  Function that is called by PHP right after the PHP process
     *  has started, and that returns an address of an internal PHP
     *  strucure with all the details and features of your extension
     *
     *  @return void*   a pointer to an address that is understood by PHP
     */
    PHPCPP_EXPORT void *get_module() 
    {
        // static(!) Php::Extension object that should stay in memory
        // for the entire duration of the process (that's why it's static)
        static Php::Extension extension("graphql-parser", "0.1.0");

        #include "Parser.php.inc"
        #include "Node.php.inc"

        // return the extension
        return extension;
    }
}
