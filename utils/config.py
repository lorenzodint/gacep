import mysql.connector
import streamlit as st

try:
    mydb = mysql.connector.connect(
        host="localhost",
        user="root",
        password="",
        database="gacep"
    )
except:
    mydb = st.error("ERRORE CONNESSIONE DB")