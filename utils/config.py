import mysql.connector
import streamlit as st


mydb = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="gacep"
)
