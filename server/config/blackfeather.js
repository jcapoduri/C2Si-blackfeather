{
    "meta": {},
    "config": {
        "version": "0.1.0", 
        "system_name": "Black Feather"
    },
    "objects": [
        {
            "name" : "user",
            "nd_fields": true,
            "fields": [
                {
                    "name": "username",
                    "type": "string"
                },
                {
                    "name": "email",
                    "type": "string"
                },
                {
                    "name": "password",
                    "type": "string"
                }
            ]
        },
        {
            "name" : "user_extends",
            "nd_fields": true,
            "fields": [
                {
                    "name": "username",
                    "type": "string"
                },
                {
                    "name": "email",
                    "type": "string"
                },
                {
                    "name": "passwd",
                    "type": "string"
                }
            ]
        },
        {
            "name" : "personal_information",
            "nd_fields": true,
            "fields": [
                {
                    "name": "name",
                    "type": "string"
                },
                {
                    "name": "lastname",
                    "type": "string"
                }
            ]
        }
    ],
    "relations": [],
    "storage": [
        {
            "name": "sql_dev",
            "type": "database",
            "db_host": "c2si.com.ar",
            "db_name": "shaka_dev_blackfeather",
            "db_user": "shaka_blackfeather",
            "db_pass": "Pretoria.46",
            "db_port": 3061,
            "db_type": "mysql"
        }
    ],
    "apps": {
        "web": {
            "storage": ["sql_dev"],
            "map": {}
        }
    }
}