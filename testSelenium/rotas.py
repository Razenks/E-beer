from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
from webdriver_manager.chrome import ChromeDriverManager
import time 

# Inicia o Chrome com driver compatível automaticamente
driver = webdriver.Chrome(service=Service(ChromeDriverManager().install()))

driver.get("http://localhost")
time.sleep(2)
print("Acessou rota nessa poha")

# Exemplo 2: rota inválida
driver.get("http://localhost/seu-projeto/rota-inexistente.php")
time.sleep(2)
if "404" in driver.page_source or "Página não encontrada" in driver.page_source:
    print("Tratamento correto para rota inexistente!")
else:
    print("⚠️ Rota inválida sem tratamento!")

# Exemplo 3: rota protegida sem login
driver.get("http://localhost/seu-projeto/admin/dashboard.php")
time.sleep(2)
if "login" in driver.current_url or "Acesso negado" in driver.page_source:
    print("Proteção correta de rota!")
else:
    print("⚠️ Acesso indevido permitido!")

driver.quit()
