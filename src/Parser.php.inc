// we are going to define the class
Php::Class<Parser> parser("AndHeiberg\\GraphQL\\Parser\\Parser");

// add methods to it
parser.method<&Parser::parse> ("parse", {
    Php::ByVal("input", Php::Type::String)
});

// add it to the extension
extension.add(std::move(parser));