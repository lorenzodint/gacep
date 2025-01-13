import streamlit as st
import utils.functions as func


def mostra():

    contenitore_login = func.contenitore(1, 2, 1)

    with contenitore_login:

        with st.container(border=True):
            st.header("Login")
            username = st.text_input("username")
            password = st.text_input("password", type="password")

            func.spazio()
            contenitore_pulsante_accedi = st.columns(3)
            with contenitore_pulsante_accedi[0]:
                accedi = st.button("Accedi")
                if accedi:
                    # elimino eventuali errori/avvisi precedenti
                    st.session_state.errore_username_vuoto = False
                    st.session_state.errore_password_vuoto = False
                    st.session_state.errore_credenziali_errate = False

                    # controllo se username vuoto
                    if username.strip() == "" or username.strip() == None:
                        # username vuoto -> mostro errore
                        st.session_state.errore_username_vuoto = True
                    else:
                        st.session_state.errore_username_vuoto = False

                        # controllo se password è vuota
                        if password.strip() == "" or password.strip() == None:
                            # password vuota -> mostro errore
                            st.session_state.errore_password_vuoto = True
                        else:
                            st.session_state.errore_password_vuoto = False

                            # input non vuoti -> controllo credenziali
                            controlloUtente = func.controlloUtente(
                                username=username, password=password)
                            if controlloUtente == "" or controlloUtente == None:
                                # controllo credenziali non ottiene nessun riscontro -> mostro errore
                                st.session_state.errore_credenziali_errate = True
                            else:
                                # controllo utente andato a buon fine
                                st.session_state.chi_loggato = controlloUtente[0]
                                st.session_state.pagina = "form"
                                st.rerun()
