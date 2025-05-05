from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
from webdriver_manager.chrome import ChromeDriverManager

# Inicia o Chrome com driver compatível automaticamente
driver = webdriver.Chrome(service=Service(ChromeDriverManager().install()))

driver.get("http://localhost")  # ou a porta correta do seu servidor

# Exemplo: tentativa de XSS
input_nome = driver.find_element(By.NAME, "nome")
input_nome.send_keys('"><script>alert("XSS")</script>')

botao = driver.find_element(By.NAME, "submit")
botao.click()
