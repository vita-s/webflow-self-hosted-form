# Form submit for self-hosted Webflow websites
Utility to easily submit form from a self hosted Webflow page. Download this folder, place it inside your Webflow repository, set settings and you are done.

## How to

### 1. Open Webflow and find all your forms you want to be able to submit

<img width="325" alt="image" src="https://user-images.githubusercontent.com/30877483/229381472-9cb980fa-25ce-415e-abc5-e5e92af9b384.png">

### 2. In settings of this "Form" element add "Custom atribute"

<img width="244" alt="image" src="https://user-images.githubusercontent.com/30877483/229381504-d22bef2b-497b-4822-a433-345a055fec5b.png">

### 3. Name your form fields correctly (the names will be used in the e-mail)

<img width="244" alt="image" src="https://user-images.githubusercontent.com/30877483/229381567-ee39af7c-9c0a-4d26-ab10-a277aac7c80d.png">

### 4. Go to "Project settings" -> "Custom Code" -> "Footer Code" and add this line

```<script src="/webflow-self-hosted-form/email.js"></script>```

### 4. Export your Webflow project

### 5. Download this project (webflow-self-hosted-form) as a ZIP file

<img width="479" alt="image" src="https://user-images.githubusercontent.com/30877483/229381392-d01bdc9e-61ef-466e-b0c1-fb77a38b017c.png">

### 6. Extract the zip and place it in the root of your exported and unziped Webflow project

<img width="288" alt="image" src="https://user-images.githubusercontent.com/30877483/229381938-c246fa54-3c15-4705-8355-2eef1d89b1e8.png">

### 7. Open file `webflow-self-hosted-form/settings.php` and set your variables accordingly

### 8. Upload to hosting and test

### 9. 🚀 Enjoy 🚀
