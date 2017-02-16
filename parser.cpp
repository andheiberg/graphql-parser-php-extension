#include <phpcpp.h>
#include <graphqlparser/c/GraphQLAst.h>
#include <graphqlparser/c/GraphQLAstNode.h>
#include <graphqlparser/c/GraphQLParser.h>
#include <graphqlparser/c/GraphQLAstToJSON.h>

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
        char *json;

        ast = graphql_parse_string(params[0], &error);

        if (ast == NULL) {
            graphql_error_free(error);
            throw Php::Exception(error);
        }

        json = (char *) graphql_ast_to_json(ast);

        Php::Value result = Php::call("json_decode", json, true);

        graphql_node_free(ast);

        return result;
    }
};