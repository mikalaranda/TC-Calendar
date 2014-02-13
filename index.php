<?php
# This function reads your DATABASE_URL configuration automatically set by Heroku
# the return value is a string that will work with pg_connect
function pg_connection_string() {
	return "dbname=d35euf91ei7rdr host=ec2-54-204-32-91.compute-1.amazonaws.com port=5432 user=lxafcokjeeqazb password=d4TwFXkULMADwv_FlbRZqxy4z0 sslmode=require"
}
 
# Establish db connection
$db = pg_connect(pg_connection_string());
if (!$db) {
    echo "Database connection error."
    exit;
}
 
$result = pg_query($db, "SELECT statement goes here");
?>

Hello World!