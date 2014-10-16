<?php
	//Define code for safe class (salt password).
	define("PBKDF2_ITERATIONS", 10);
    define("PBKDF2_SALT_BYTE_SIZE", 16);
    define("PBKDF2_HASH", "$2a$%02d$");

   
    class setting {

    	public static $DO_DEBUG = true;
    	public static $ERROR_LOG = "myerrors.log";
    }