import streamlit as st
import os
import json
import subprocess


# IMPORT FILE
import utils.functions as func


def mostra():

    php_output = []

    # sql per ottenere lista cliniche
    lista_cliniche = func.select_all(
        distinct=True, colonne=["codice", "denominazione"], tabella="strutture")

    nomi_strutture = []
    codice_strutture = []

    for clinica in lista_cliniche:
        nomi_strutture.append(clinica[1])
        codice_strutture.append(clinica[0])

    contenitore_form = st.container(border=True)
    with contenitore_form:
        st.header("Caricamento file prestazioni")
        func.spazio()

        col1, col2, col3 = st.columns(
            [1.5, 0.5, 1], gap="medium", vertical_alignment="center")

        with col1:
            # combobox strutture
            struttura_selezionata = st.selectbox(
                label="Struttura", options=nomi_strutture, index=None, placeholder="Seleziona una struttura...")

            if struttura_selezionata:
                st.session_state.errore_struttura_non_selezionata = False
        with col3:
            file1 = st.file_uploader("File C1:", type=["txt"])
            st.session_state.errore_file1_non_selezionato = False
            st.write("""---""")
            file2 = st.file_uploader("File C2:", type=["txt"])
            st.session_state.errore_file2_non_selezionato = False

        func.spazio()
        carica = st.button("Carica")

        if carica:
            controllo_form = func.controlloForm(
                sessionState=st.session_state,
                struttura=struttura_selezionata,
                file1=file1,
                file2=file2)

            if controllo_form:
                st.session_state.errore_import_php = False
                st.session_state.errore_struttura_non_selezionata = False
                st.session_state.errore_file1_non_selezionato = False
                st.session_state.errore_file2_non_selezionato = False

                filePath1 = os.path.join("filePrestazioni", "fileC1")
                filePath2 = os.path.join("filePrestazioni", "fileC2")

                with open(filePath1, "wb") as f:
                    f.write(file1.getbuffer())
                with open(filePath2, "wb") as f:
                    f.write(file2.getbuffer())

                try:

                    result = subprocess.run(
                        ["php", "import.php"],
                        capture_output=True,
                        text=True,
                        check=True
                    )

                    php_output = json.loads(result.stdout.strip())

                except subprocess.CalledProcessError as e:
                    st.session_state.errore_import_php = True

    col1, col2, col3 = st.columns([1, 2, 1])

    with col2:
        errFile1 = st.expander("Errori File C1")
        with errFile1:
            for x in php_output:
                st.error(f"{x} {php_output[x]}")
