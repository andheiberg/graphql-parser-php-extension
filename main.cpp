#include <phpcpp.h>
#include "parser.cpp"

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
        
        // we are going to define a class
        Php::Class<Parser> parser("AndHeiberg\\GraphQL\\Parser\\Parser");
        
        // add methods to it
        parser.method<&Parser::parse> ("parse", {
            Php::ByVal("input", Php::Type::String)
        });

        // add it to the extension
        extension.add(std::move(parser));
        
        // return the extension
        return extension;
    }
}
