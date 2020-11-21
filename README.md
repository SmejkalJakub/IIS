# Informační systém pro psaní testů **EasyTests** :book:
## Vytvořen v rámci projektu do předmětu IIS na FIT VUT v Brně
## Listopad 2020
## Autoři Jakub Smejkal, Dominik Nejedlý, Adam Grünwald

- - - -

## Popis
Informační systém umožňuje správu, vytváření a psaní testů. Testové otázky mohou býti buďto otevřené, nebo uzavřené (abcd). Lze k nim přidávat doplňující obrázky k zadání.
Otázky spadají do kategorií, které určují, kolik bodů lze získat za správně zodpovězenou otázku.
Při vytváření testu lze definovat, kolik otázek z dané kategorie bude do každé instance testu náhodně vygenerováno. Test se může skládat z vícero kategorií, přičemž maximální bodový zisk z testu je součtem bodů za všechny otázky, který závisí na počtu otázek vybraných z konktétní kategorie. Tato hodnota se tudíž dopočítává.
Student se může přihlašovat na testy, psát je a dívat se na jejich hodnocení.
Asistent má práva studenta, a navíc může potvrzovat žádosti o přihlášení na test studenta, přihlašovat se na opravy testu a opravovat jednotlivé instance testu
Profesor má práva asistenta, dále může vytvářet, upravovat a mazat svoje testy a schvalovat žádosti asistentů na opravu jeho testu.
Admin má práva profesora, navíc může přidávat nové uživatele.

## Použití
### Vytvoření nového účtu
Každý nově příchozí uživatel má dvě možnosti, jak získat přístup do informačního systému:
* Vytvoří si nový účet v úvodní stránce pro nepřihlášeného uživatele
* Požádá admina o vytvoření nového účtu a na e-mail mu přijdou přihlašovací údaje

### Přihlášení na test
#### Na psaní
**TESTS -> Available**, kde se studentovi ukáží testy, na které ještě není přihlášen. Zde si může prohlédnou detail testu, případně se na na test přihlásit. Stav žádosti a možnost odhlášení se z testu, který ještě nezačal, nalezne v tabulce **TESTS-> Registered**, kde nalezne buď stav *pending* nebo *confirmed*. Kliknutím na tlačítko Sign off ve sloupci **Apply** může svoji žádost stáhnout.

#### Na opravu
Podobně jako žádosti na psaní jsou koncipovány i žádosti o opravu. Zde si uživatel s rolí asistent a výš vybere z rozbalovacího menu Tests tabulku Available v sekci Correction. Zde se může na testy přihlašovat. Stav přihlášených testů na opravu může sledovat v okně Registered (sekce Correction). U těch, které ještě nezačaly, a na něž mu byla schválena žádost o opravu, lze s rolí asistenta schvalovat žádosti studentů. 

### Vyplňování a revize testů
#### Vyplňování testů
Uživatel spustí test z okna Active kliknutím na test a na Start test. 
### Oprava testů
V okně Active (sekce Correction) jsou testy, které již začaly. Při kliknutí na detail testu se objeví instance testů studentů, kteří již ukončili svůj test, a lze tak začít s opravou jejich instancí. Stejně tak v okně History lze spatřit testy a instance, které již byly ukončeny

### Vytvoreni a editace testu

### Sprava Uzivatelu z pohledu admina

