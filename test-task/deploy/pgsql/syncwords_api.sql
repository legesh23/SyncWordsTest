--
-- PostgreSQL port of the MySQL "World" database.
--
-- The sample data used in the world database is Copyright Statistics
-- Finland, http://www.stat.fi/worldinfigures.
--

BEGIN;

SET client_encoding = 'utf8';

CREATE TABLE users (
    id integer NOT NULL,
    name text NOT NULL,
    email text NOT NULL,
    password text NOT NULL
);
