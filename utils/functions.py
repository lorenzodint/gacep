import hashlib
import utils.config as con
import streamlit as st


cursor = con.mydb.cursor()


def select_all(distinct: bool, colonne: list, tabella: str):
    query = "SELECT"
    if distinct:
        query += " DISTINCT"

    if len(colonne) == 0 or not colonne:
        query += " *"
    else:
        for colonna in colonne:
            query += f" {colonna},"
        query = query[:-1]

    query += f" FROM {tabella} ORDER BY denominazione ASC"

    try:
        cursor.execute(query)
        result = cursor.fetchall()
        return result
    except:
        print("errore esecuzione query select all")


def controlloForm(sessionState, struttura, file1, file2):
    if struttura == "" or struttura == None:
        sessionState.errore_struttura_non_selezionata = True
        return False

    if file1 == "" or file1 == None:
        sessionState.errore_file1_non_selezionato = True
        return False

    if file2 == "" or file2 == None:
        sessionState.errore_file2_non_selezionato = True
        return False

    return True


def registraUtente(username, password):
    passHash = hashlib.sha256(password.encode()).hexdigest()

    query = "INSERT INTO utenti (username, password) VALUES (%s, %s)"
    val = (username, passHash)

    try:
        cursor.execute(query, val)
        con.mydb.commit()
    except:
        print("errore esecuzione query registra utente")


# registraUtente("aslPescara", "Password.Sicura")

def controlloUtente(username, password):
    passHash = hashlib.sha256(password.encode()).hexdigest()

    query = "SELECT * FROM utenti WHERE username = %s AND password = %s"
    val = (username, passHash)
    try:
        cursor.execute(query, val)
        result = cursor.fetchone()
        return result
    except:
        print("errore query controllo utente")


def contenitore(c1=1, c2=1, c3=1, posizione="center", gap="large"):
    col1, col2, col3 = st.columns(
        [c1, c2, c3], gap=gap, vertical_alignment="center")

    if posizione == "left":
        return col1
    if posizione == "center":
        return col2
    if posizione == "right":
        return col3


def spazio(n=1):
    spazio = st.write("""<br>""" * n, unsafe_allow_html=True)
    return spazio
