import mysql.connector
from mysql.connector import Error
import pandas as pd

def create_server_connection(host_name, user_name, user_password):
    connection = None
    try:
        connection = mysql.connector.connect(
            host=host_name,
            user=user_name,
            passwd=user_password
        )
        print("MySQL Database connection successful")
    except Error as err:
        print(f"Error: '{err}'")

    return(connection)

def create_db_connection(host_name, user_name, user_password, db_name):
    connection = None
    try:
        connection = mysql.connector.connect(
            host=host_name,
            user=user_name,
            passwd=user_password,
            database=db_name
        )
        print("MySQL Database connection successful")
    except Error as err:
        print(f"Error: '{err}'")

    return(connection)


def create_database(connection, db_name):
    query = "CREATE DATABASE " + db_name
    cursor = connection.cursor()
    try:
        cursor.execute(query)
        print("Database created successfully")
    except Error as err:
        print(f"Error: '{err}'")


def execute_query(connection, query):
    cursor = connection.cursor()
    try:
        cursor.execute(query)
        connection.commit()
        print("Query successful")
    except Error as err:
        print(f"Error: '{err}'")


def read_query(connection, query):
    cursor = connection.cursor()
    result = None
    try:
        cursor.execute(query)
        result = cursor.fetchall()
        return result
    except Error as err:
        print(f"Error: '{err}'")



def create_new_database(db_name):
    server_connection = create_server_connection('localhost', 'root', 'root')
    create_database(server_connection, db_name)
    connection = create_db_connection('localhost', 'root', 'root', db_name)
    sqlEmployees = 'CREATE TABLE employee (employeeId int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL, employeeSetId int(128) NOT NULL, phoneNr int(128) NOT NULL, leaderSetId int(11) NOT NULL, question1answer1 int(128), question1answer2 int(128), question1answer3 int(128), question1answer4 int(128), question1answer5 int(128), question2answer1 int(128), question2answer2 int(128), question2answer3 int(128), question2answer4 int(128), question2answer5 int(128), question3answer1 int(128), question3answer2 int(128), question3answer3 int(128), question3answer4 int(128), question3answer5 int(128));'
    sqlLeaders = 'CREATE TABLE leader (leaderId int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL, leaderSetId int(128) NOT NULL, phoneNr int(128) NOT NULL, avgAnswer1 int(128), avgAnswer2 int(128), avgAnswer3 int(128), avgAnswer4 int(128), avgAnswer5 int(128));'
    sqlProgram = 'CREATE TABLE program (programId int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL, roundNumber int(128) NOT NULL, questionsNr int(128) NOT NULL, question1 varchar(1000), question2 varchar(1000), question3 varchar(1000));'
    execute_query(connection, sqlEmployees)
    execute_query(connection, sqlLeaders)
    execute_query(connection, sqlProgram)

def insert_data(data, connection):
    programSql = "INSERT INTO program (programId, roundNumber, questionsNr, question1, question2, question3) VALUES (NULL, 1, 3, 'Question1: rate blue?', 'Question2: how many days until tuesday?', 'Question 3: favorite number?');"
    execute_query(connection, programSql)
    for leader in data:
        leaderSetId = str(leader['setId'])
        leaderPhoneNr = str(leader['phoneNr'])
        employeeSetIds = leader['employeeSetIds']
        employeePhoneNrs = leader['employeePhoneNrs']

        sqlLeader = 'INSERT INTO leader  (leaderId, leaderSetId, phoneNr) VALUES (NULL, ' + leaderSetId + ', ' + leaderPhoneNr + ');'
        execute_query(connection, sqlLeader)
        for i in range(len(employeeSetIds)):
            employeeSetId = str(employeeSetIds[i])
            employeePhoneNr = str(employeePhoneNrs[i])
            sqlEmployee = 'INSERT INTO employee  (employeeId, employeeSetId, phoneNr, leaderSetId) VALUES (NULL, ' + employeeSetId + ', ' + employeePhoneNr + ', ' + leaderSetId + ');'
            execute_query(connection, sqlEmployee)



data = [
    [1, 1283888, [111, 112, 113, 114], [1111111, 12222222, 13333333, 14444444]],
    [2, 2283888, [211, 212, 213, 314], [2111111, 22222222, 23333333, 24444444]],
    [3, 3283888, [311, 312, 313, 314], [3111111, 32222222, 33333333, 34444444]]
]

def set_round_nr(nr, connection):
    sql = 'UPDATE program SET roundNumber=' + str(nr) + ' WHERE programId=1'
    execute_query(connection, sql)



data_dicts = [
    {   'setId': 1,
        'phoneNr': 1283888,
        'employeeSetIds': [111, 112, 113, 114],
        'employeePhoneNrs': [1111111, 12222222, 13333333, 14444444] }
            ]


create_new_database('appelsin')
connection = create_db_connection('', '', '', '')

insert_data(data_dicts, connection)

#set_round_nr(2, connection)
