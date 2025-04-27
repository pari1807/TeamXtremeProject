const container = document.querySelector(".container");
const chatsContainer = document.querySelector(".chats-container");
const promptForm = document.querySelector(".prompt-form");
const promptInput = promptForm.querySelector(".prompt-input");

const API_KEY="AIzaSyDSWoxZO1_2nKjydqBqF9gOh8vbI0pZ56g";
// API URL for Gemini 2.0 Flash model
const API_URL =`https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=${API_KEY}`;

let userMessage = "";
const chatHistory = [];
// Function to create message elements
const createMsgElement = (content, ...classes) => {
  const div = document.createElement("div");
  div.classList.add("message", ...classes);
  div.innerHTML = content;
  return div;
};

const scrollToBottom = () => chatsContainer.scrollTo({
  top: chatsContainer.scrollHeight,
  behavior: "smooth"
});

const typingEffect = (text,textElement,botMsgDiv) => {
    textElement.textContent = ""; // Clear the text content
    const words = text.split(" ");
    let wordIndex = 0;
    const typingInterval = setInterval(() => {
        if(wordIndex < words.length){
            textElement.textContent += (wordIndex===0 ? "" : " ")+ words[wordIndex++];// Add the
        }else{
            clearInterval(typingInterval);
            botMsgDiv.classList.remove("loading"); // Stop the typing effect
        }
    },40);
}

const generateResponse =async (botMsgDiv) => {
    const textElement = botMsgDiv.querySelector(".message-text");
    chatHistory.push({
        role: "user",
        parts: [{text: userMessage}]
    })

    try{
        const response = await fetch(API_URL,{
            method: "POST",
            headers:{"Content-Type": "application/json"},
            body: JSON.stringify({contents: chatHistory}),
        });
        const data = await response.json();
        if(!response.ok){
            throw new Error(data.error.message || "Error generating response");
        }
        const responseText =  data.candidates[0].content.parts[0].text.replace(/\*\*([^\*]+)\*\*/g, "$1").trim();
        typingEffect(responseText,textElement,botMsgDiv);
        chatHistory.push({
            role: "model",
            parts: [{text: responseText}]
        });
    }catch(error){
        console.log(error);
    }
}

// Function to add rotation animation to the SVG
const addRotationAnimation = (element) => {
  element.style.animation = "rotate 2s linear infinite";
};

// Handle the form submission
const handleFormSubmit = (e) => {
  e.preventDefault();
  userMessage = promptInput.value.trim(); // Use the native trim() method safely
  if (!userMessage) return;

  promptInput.value="";  // Generate user message HTML and add it to the chats container
  const userMsgHTML = `<p class="message-text"></p>`;
  const userMsgDiv = createMsgElement(userMsgHTML, "user-message");
  userMsgDiv.querySelector(".message-text").textContent = userMessage;
  chatsContainer.appendChild(userMsgDiv);
  scrollToBottom();

  // Generate bot message HTML and add it to the chats container in 600ms
  setTimeout(() => {
    const botMsgHTML = `<img src="logo.svg" class="avatar"><p class="message-text">Just a sec...</p>`;
    const botMsgDiv = createMsgElement(botMsgHTML, "bot-message","loading");
    chatsContainer.appendChild(botMsgDiv);
    scrollToBottom();
    generateResponse(botMsgDiv);

    // Add rotation animation to the SVG
    const avatar = botMsgDiv.querySelector(".avatar");
    addRotationAnimation(avatar);
  }, 600);

  // Clear the input
  promptInput.value = "";
};

// Add CSS for rotation animation
document.head.insertAdjacentHTML("beforeend", `
<style>
@keyframes rotate {
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(360deg);
  }
}
</style>
`);

promptForm.addEventListener("submit", handleFormSubmit);
