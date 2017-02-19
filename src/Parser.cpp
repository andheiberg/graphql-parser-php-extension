#include <phpcpp.h>
#include <graphqlparser/c/GraphQLAst.h>
#include <graphqlparser/c/GraphQLAstNode.h>
#include <graphqlparser/c/GraphQLParser.h>
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
        struct GraphQLAstNode *ast;
        const char *error;

        ast = graphql_parse_string(params[0], &error);

        if (ast == NULL) {
            graphql_error_free(error);
            throw Php::Exception(error);
        }

        ASTToPHPVisitor visitor;
        ((facebook::graphql::ast::Node *) ast)->accept(&visitor);
        Php::Value result = visitor.getResult();
        
        graphql_node_free(ast);

        return result;
    }
};