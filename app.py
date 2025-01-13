import streamlit as st
import os

# IMPORT FILE
import utils.functions as func
import utils.errori as er


# IMPORT PAGINE
import pagine
import pagine.form
import pagine.login


# CREAZIONE CARTELLA PER FILE
if not os.path.exists("filePrestazioni"):
    os.makedirs("filePrestazioni")


# LAYOUT PAGINA
st.set_page_config(layout="wide")

st.write("""<meta name="viewport" content="width=device-width, initial-scale=1.0">""",
         unsafe_allow_html=True)

# IMPORT CSS
def local_css(fileName):
    with open(fileName) as f:
        st.write(f"""<style>{f.read()}</style>""", unsafe_allow_html=True)


# CARICO FILE CSS
# local_css("style/style.css")




# SESSION STATE PRINCIPALI
if 'pagina' not in st.session_state:
    st.session_state.pagina = 'login'
if 'chi_loggato' not in st.session_state:
    st.session_state.chi_loggato = "0"

#  SESSION STATE ERRORI
er.session_errori()



# CONTROLLO SE LOGGATO
if st.session_state.chi_loggato == "0":
    st.session_state.pagina = "login"

# MOSTRA PAGINA CORRENTE
if st.session_state.pagina == "login":
    pagine.login.mostra()

if st.session_state.pagina == "form":
    pagine.form.mostra()


# mostra eventuali errori
er.mostra()


st.write(st.session_state)
