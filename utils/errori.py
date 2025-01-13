import streamlit as st
import utils.functions as func


def session_errori():
    if 'errore' not in st.session_state:
        st.session_state.errore = ""
    if 'avviso' not in st.session_state:
        st.session_state.avviso = ""

    if 'errore_username_vuoto' not in st.session_state:
        st.session_state.errore_username_vuoto = False
    if 'errore_password_vuoto' not in st.session_state:
        st.session_state.errore_password_vuoto = False
    if 'errore_credenziali_errate' not in st.session_state:
        st.session_state.errore_credenziali_errate = False
    if 'errore_struttura_non_selezionata' not in st.session_state:
        st.session_state.errore_struttura_non_selezionata = False
    if 'errore_file1_non_selezionato' not in st.session_state:
        st.session_state.errore_file1_non_selezionato = False
    if 'errore_file2_non_selezionato' not in st.session_state:
        st.session_state.errore_file2_non_selezionato = False
    if 'errore_import_php' not in st.session_state:
        st.session_state.errore_import_php = False


def mostra():
    # contenitore per mostrare eventuali errori/avvisi
    contenitore_errori = func.contenitore(1, 2, 1)
    with contenitore_errori:
        if st.session_state.avviso != "":
            st.warning(st.session_state.avviso)
        if st.session_state.errore != "":
            st.error(st.session_state.errore)
        if st.session_state.errore_username_vuoto:
            st.error("Il campo Username non può essere vuoto.")
        if st.session_state.errore_password_vuoto:
            st.error("Il campo Password non può essere vuoto.")
        if st.session_state.errore_credenziali_errate:
            st.error("Username o Password errati.")
        if st.session_state.errore_struttura_non_selezionata:
            st.error("Nessuna struttura selezionata.")
            st.write("ERRORE STRUTTURA")
        if st.session_state.errore_file1_non_selezionato:
            st.error("File C1 mancante.")
        if st.session_state.errore_file2_non_selezionato:
            st.error("File C2 mancante.")
        if st.session_state.errore_import_php:
            st.error("Errore importazione fileC1/fileC2")
