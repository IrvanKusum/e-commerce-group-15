// Chatbot functionality
class ChatbotWidget {
    constructor() {
        this.isOpen = false;
        this.messages = [];
        this.init();
    }

    init() {
        this.createWidget();
        this.attachEventListeners();
        this.addWelcomeMessage();
    }

    createWidget() {
        const widgetHTML = `
            <div class="chatbot-widget">
                <!-- Toggle Button -->
                <button class="chatbot-toggle" id="chatbotToggle">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12c0 1.54.36 3 .97 4.29L2 22l5.71-.97C9 21.64 10.46 22 12 22c5.52 0 10-4.48 10-10S17.52 2 12 2zm0 18c-1.38 0-2.66-.36-3.79-.98l-.27-.14-2.67.45.45-2.67-.14-.27C4.36 14.66 4 13.38 4 12c0-4.41 3.59-8 8-8s8 3.59 8 8-3.59 8-8 8z"/>
                        <circle cx="8.5" cy="12" r="1.5"/>
                        <circle cx="15.5" cy="12" r="1.5"/>
                        <path d="M12 15.5c1.38 0 2.5-.84 2.5-1.88h-5c0 1.04 1.12 1.88 2.5 1.88z"/>
                    </svg>
                </button>
                
                <!-- Chatbot Container -->
                <div class="chatbot-container hidden" id="chatbotContainer">
                    <div class="chatbot-header">
                        <h3>🤖 FlexSport Assistant</h3>
                        <button class="close-btn" id="chatbotClose">×</button>
                    </div>
                    
                    <div class="chatbot-messages" id="chatbotMessages">
                        <!-- Messages will be inserted here -->
                    </div>
                    
                    <div class="chatbot-input-area">
                        <form class="chatbot-input-form" id="chatbotForm">
                            <input 
                                type="text" 
                                class="chatbot-input" 
                                id="chatbotInput"
                                placeholder="Tanya tentang produk yang Anda butuhkan..."
                                autocomplete="off"
                            >
                            <button type="submit" class="chatbot-send-btn" id="chatbotSend">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        `;

        document.body.insertAdjacentHTML('beforeend', widgetHTML);
    }

    attachEventListeners() {
        const toggle = document.getElementById('chatbotToggle');
        const close = document.getElementById('chatbotClose');
        const form = document.getElementById('chatbotForm');

        toggle.addEventListener('click', () => this.toggleChat());
        close.addEventListener('click', () => this.toggleChat());
        form.addEventListener('submit', (e) => this.handleSubmit(e));
    }

    toggleChat() {
        this.isOpen = !this.isOpen;
        const container = document.getElementById('chatbotContainer');

        if (this.isOpen) {
            container.classList.remove('hidden');
            document.getElementById('chatbotInput').focus();
        } else {
            container.classList.add('hidden');
        }
    }

    addWelcomeMessage() {
        const welcomeMsg = {
            type: 'bot',
            message: 'Halo! 👋 Saya AI Assistant FlexSport. Saya bisa membantu Anda menemukan produk yang tepat. Coba tanya seperti: "Saya ingin sepatu yang aman untuk melindungi ankle" atau "Rekomendasikan sepatu running"',
            timestamp: new Date()
        };

        this.messages.push(welcomeMsg);
        this.renderMessage(welcomeMsg);
    }

    async handleSubmit(e) {
        e.preventDefault();

        const input = document.getElementById('chatbotInput');
        const message = input.value.trim();

        if (!message) return;

        // Add user message
        this.addMessage('user', message);
        input.value = '';

        // Show typing indicator
        this.showTypingIndicator();

        try {
            // Send to backend
            const response = await fetch('/chatbot/message', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ message })
            });

            const data = await response.json();

            // Remove typing indicator
            this.hideTypingIndicator();

            if (data.success) {
                this.addMessage('bot', data.data.message, data.data.products);
            } else {
                this.addMessage('bot', 'Maaf, terjadi kesalahan. Silakan coba lagi.');
            }
        } catch (error) {
            console.error('Chatbot error:', error);
            this.hideTypingIndicator();
            this.addMessage('bot', 'Maaf, terjadi kesalahan koneksi. Silakan coba lagi.');
        }
    }

    addMessage(type, message, products = null) {
        const msg = {
            type,
            message,
            products,
            timestamp: new Date()
        };

        this.messages.push(msg);
        this.renderMessage(msg);
    }

    renderMessage(msg) {
        const messagesContainer = document.getElementById('chatbotMessages');

        if (msg.type === 'user') {
            const userMsgHTML = `
                <div class="chatbot-message user">
                    <div class="message-content">
                        <div class="message-bubble">${this.escapeHtml(msg.message)}</div>
                    </div>
                </div>
            `;
            messagesContainer.insertAdjacentHTML('beforeend', userMsgHTML);
        } else {
            let botMsgHTML = `
                <div class="chatbot-message bot">
                    <div class="message-avatar">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                            <circle cx="8.5" cy="11" r="1.5"/>
                            <circle cx="15.5" cy="11" r="1.5"/>
                            <path d="M12 17.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"/>
                        </svg>
                    </div>
                    <div class="message-content">
                        <div class="message-bubble">${this.escapeHtml(msg.message)}</div>
            `;

            if (msg.products && msg.products.length > 0) {
                botMsgHTML += '<div class="product-recommendations">';
                msg.products.forEach(product => {
                    botMsgHTML += `
                        <a href="/product/${product.id}" class="product-card">
                            <img src="${product.image}" alt="${this.escapeHtml(product.name)}" class="product-image">
                            <div class="product-info">
                                <div class="product-category">${this.escapeHtml(product.category)}</div>
                                <div class="product-name">${this.escapeHtml(product.name)}</div>
                                <div class="product-price">Rp ${this.formatPrice(product.price)}</div>
                            </div>
                        </a>
                    `;
                });
                botMsgHTML += '</div>';
            }

            botMsgHTML += `
                    </div>
                </div>
            `;

            messagesContainer.insertAdjacentHTML('beforeend', botMsgHTML);
        }

        // Scroll to bottom
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    showTypingIndicator() {
        const messagesContainer = document.getElementById('chatbotMessages');
        const typingHTML = `
            <div class="chatbot-message bot typing-message">
                <div class="message-avatar">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                    </svg>
                </div>
                <div class="message-content">
                    <div class="message-bubble typing-indicator">
                        <span class="typing-dot"></span>
                        <span class="typing-dot"></span>
                        <span class="typing-dot"></span>
                    </div>
                </div>
            </div>
        `;
        messagesContainer.insertAdjacentHTML('beforeend', typingHTML);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    hideTypingIndicator() {
        const typing = document.querySelector('.typing-message');
        if (typing) typing.remove();
    }

    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    formatPrice(price) {
        return new Intl.NumberFormat('id-ID').format(price);
    }
}

// Initialize chatbot when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    new ChatbotWidget();
});
