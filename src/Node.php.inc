// Position PHP class
Php::Class<Position> position("AndHeiberg\\GraphQL\\Parser\\AST\\Position");

position.method<&Position::__construct> ("__construct", {
	Php::ByVal("filename", Php::Type::String),
	Php::ByVal("line", Php::Type::Numeric),
	Php::ByVal("column", Php::Type::Numeric)
});
position.method<&Position::getFilename> ("getFilename");
position.method<&Position::getLine> ("getLine");
position.method<&Position::getColumn> ("getColumn");

extension.add(std::move(position));

// Location PHP class
Php::Class<Location> location("AndHeiberg\\GraphQL\\Parser\\AST\\Location");

location.method<&Location::__construct> ("__construct", {
	Php::ByVal("start", "AndHeiberg\\GraphQL\\Parser\\AST\\Position"),
	Php::ByVal("end", "AndHeiberg\\GraphQL\\Parser\\AST\\Position")
});
location.method<&Location::getStart> ("getStart");
location.method<&Location::getEnd> ("getEnd");

extension.add(std::move(location));

// Node PHP class
Php::Class<Node> node("AndHeiberg\\GraphQL\\Parser\\AST\\Node");

node.method<&Node::__construct> ("__construct", {
	Php::ByVal("location", "AndHeiberg\\GraphQL\\Parser\\AST\\Location")
});
node.method<&Node::getLocation> ("getLocation");

extension.add(std::move(node));
