const PRODUCTION_URL = "https://app.remodelai.com/chatbot-plugin/chatbot.js"
const DEV_URL = "https://app.useremodel.ai/chatbot-plugin/chatbot.js"
const QA_URL = "https://app-qa.useremodel.ai/chatbot-plugin/chatbot.js"


jQuery(document).ready(function ($) {
  // ... Other code ...

  fetch(DEV_URL)
    .then((response) => response.text())
    .then((data) => {
      const modifiedData = data.replace(/\\"/g, '"');

      // Create a script element and set its content to the fetched code
      const scriptElement = document.createElement("script");
      scriptElement.innerHTML = modifiedData;

      // Append the script element to the document's head
      document.head.appendChild(scriptElement);

      // Call window.Chatbot.renderChatbot() after the script is loaded and executed
      window.Chatbot.renderChatbot(
        JSON.parse(remodel_ai_chatbot_Params.param1.replace(/\\"/g, '"'))
      );
    })
    .catch((error) => {
      console.error("Error fetching code:", error);
    });
});
