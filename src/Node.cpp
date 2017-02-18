#pragma once

#include <phpcpp.h>

class Position : public Php::Base
{
private:
    int _filename;
    int _line;
    int _column;
public:
    Position() = default;
    virtual ~Position() = default;

    /**
     *  php "constructor"
     *  @param  params
     */
    void __construct(Php::Parameters &params)
    {
        _filename = params[0];
        _line = params[1];
        _column = params[2];
    }

    /**
     *  @val Php::Value
     *  @valPHP int
     */
    Php::Value getFilename()
    {
        return _filename;
    }

    /**
     *  @val Php::Value
     *  @valPHP int
     */
    Php::Value getLine()
    {
        return _line;
    }

    /**
     *  @val Php::Value
     *  @valPHP int
     */
    Php::Value getColumn()
    {
        return _column;
    }
};

class Location : public Php::Base
{
private:
    /**
     *  @val Php::Value
     *  @valPHP Position
     */
    Php::Value _start;

    /**
     *  @val Php::Value
     *  @valPHP Position
     */
    Php::Value _end;
public:
    Location() = default;
    virtual ~Location() = default;

    /**
     *  php "constructor"
     *  @param  params
     */
    void __construct(Php::Parameters &params)
    {
        _start = params[0];
        _end = params[1];
    }

    /**
     *  @return Php::Value
     *  @returnPHP Position
     */
    Php::Value getStart()
    {
        return _start;
    }

    /**
     *  @return Php::Value
     *  @returnPHP Position
     */
    Php::Value getEnd()
    {
        return _end;
    }
};

class Node : public Php::Base
{
private:
    /**
     *  @var Php::Value
     *  @varPHP Location
     */
    Php::Value _location;

public:
    Node() = default;
    virtual ~Node() = default;

    /**
     *  php "constructor"
     *  @param  params
     */
    void __construct(Php::Parameters &params)
    {
        _location = params[0];
    }
    
    /**
     *  @return Php::Value
     *  @returnPHP Location
     */
    Php::Value getLocation() const
    {
        return _location;
    }

    void setLocation(Php::Value l)
    {
        _location = l;
    }
};