#include <phpcpp.h>
#include <graphqlparser/GraphQLParser.h>
#include <graphqlparser/JsonVisitor.h>
#include <graphqlparser/AstNode.h>
#include "../generated/ASTToPHPVisitor.cpp"

class Parser : public Php::Base
{
public:
    /**
     *  C++ constructor and destructor
     */
    Parser() = default;
    virtual ~Parser() = default;
    
    Php::Value parse(Php::Parameters &params)
    {
        const char *error;

        facebook::graphql::ast::Node *ast = facebook::graphql::parseStringWithExperimentalSchemaSupport(
            params[0], &error
        ).release();

        if (ast == NULL) {
            throw Php::Exception(error);
            std::free((void *)error);
        }

        ASTToPHPVisitor visitor;
        ast->accept(&visitor);
        Php::Value result = visitor.getResult();
        
        delete ast;

        return result;
    }
};