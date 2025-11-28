@extends('frontend.front_app')

@section('title', 'AI Phone Expert - ' . getSetting('site_name', 'Mobile Hub'))

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Header -->
            <div class="text-center mb-5">
                <div class="ai-icon mb-3">
                    <i class="fas fa-robot fa-3x text-primary"></i>
                </div>
                <h1 class="display-5 fw-bold text-dark">AI Phone Expert</h1>
                <p class="lead text-muted">Describe your dream phone and get personalized recommendations!</p>
            </div>

            <!-- Chat Container -->
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white py-3">
                    <h4 class="mb-0">
                        <i class="fas fa-comments me-2"></i>
                        Chat with Our AI Assistant
                    </h4>
                </div>

                <div class="card-body p-0">
                    <!-- Chat Messages -->
                    <div class="chat-messages p-4" id="chatMessages" style="height: 400px; overflow-y: auto;">
                        <div class="ai-message mb-3">
                            <div class="d-flex align-items-start">
                                <div class="ai-avatar me-3">
                                    <i class="fas fa-robot fa-lg text-primary"></i>
                                </div>
                                <div class="message-content">
                                    <div class="message-bubble ai-bubble">
                                        <p class="mb-1">👋 Hello! I'm your personal phone expert.</p>
                                        <p class="mb-1">Tell me about your preferences:</p>
                                        <ul class="mb-0">
                                            <li>💰 Your budget range (BDT)</li>
                                            <li>🏷️ Preferred brands</li>
                                            <li>📸 Camera requirements</li>
                                            <li>⚡ Performance needs</li>
                                            <li>🔋 Battery life expectations</li>
                                            <li>🎯 Any specific features</li>
                                        </ul>
                                        <p class="mt-2 mb-0"><small>Example: "I need a phone under 30,000 BDT with good camera and long battery life for gaming"</small></p>
                                    </div>
                                    <small class="text-muted">Just now</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Chat Input -->
                    <div class="chat-input border-top p-3">
                        <form id="aiChatForm">
                            @csrf
                            <input type="hidden" name="session_id" id="sessionId" value="{{ uniqid('ai_') }}">

                            <div class="input-group">
                                <input type="text"
                                       name="message"
                                       id="userMessage"
                                       class="form-control border-0"
                                       placeholder="Describe your dream phone..."
                                       autocomplete="off"
                                       required>
                                <button type="submit" class="btn btn-primary" id="sendButton">
                                    <i class="fas fa-paper-plane me-1"></i> Send
                                </button>
                            </div>

                            <!-- Quick Suggestions -->
                            <div class="quick-suggestions mt-2">
                                <small class="text-muted me-2">Quick tips:</small>
                                <button type="button" class="btn btn-outline-secondary btn-sm suggestion-btn" data-message="Best phone under 25,000 BDT">
                                    💰 Budget 25k
                                </button>
                                <button type="button" class="btn btn-outline-secondary btn-sm suggestion-btn" data-message="Gaming phone with good camera under 35,000 BDT">
                                    🎮 Gaming + Camera
                                </button>
                                <button type="button" class="btn btn-outline-secondary btn-sm suggestion-btn" data-message="Long battery life phone under 20,000 BDT">
                                    🔋 Long Battery
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Recommendations Section -->
            <div class="recommendations-section mt-4 d-none" id="recommendationsSection">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-success text-white py-3">
                        <h5 class="mb-0">
                            <i class="fas fa-star me-2"></i>
                            Recommended Phones For You
                        </h5>
                    </div>
                    <div class="card-body">
                        <div id="aiRecommendations" class="row">
                            <!-- AI recommendations will appear here -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Guest Notice -->
            @guest
            <div class="alert alert-info mt-4 text-center">
                <i class="fas fa-info-circle me-2"></i>
                You're using AI recommendations as a guest.
                <a href="{{ route('login') }}" class="alert-link">Login</a> to save your conversation history.
            </div>
            @endguest
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.ai-icon {
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

.chat-messages {
    background: #f8f9fa;
    border-radius: 0 0 0.375rem 0.375rem;
}

.message-bubble {
    max-width: 80%;
    padding: 12px 16px;
    border-radius: 18px;
    margin-bottom: 5px;
    word-wrap: break-word;
}

.ai-bubble {
    background: white;
    border: 1px solid #e9ecef;
    border-bottom-left-radius: 5px;
}

.user-bubble {
    background: #007bff;
    color: white;
    margin-left: auto;
    border-bottom-right-radius: 5px;
}

.ai-avatar, .user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.ai-avatar {
    background: #e9ecef;
}

.user-avatar {
    background: #007bff;
    color: white;
}

.quick-suggestions {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    align-items: center;
}

.suggestion-btn {
    font-size: 0.75rem;
    padding: 4px 10px;
    border-radius: 15px;
}

.typing-indicator {
    display: inline-flex;
    align-items: center;
    padding: 8px 0;
}

.typing-dot {
    width: 8px;
    height: 8px;
    background: #6c757d;
    border-radius: 50%;
    margin: 0 2px;
    animation: typing 1.4s infinite;
}

.typing-dot:nth-child(2) { animation-delay: 0.2s; }
.typing-dot:nth-child(3) { animation-delay: 0.4s; }

@keyframes typing {
    0%, 100% { transform: translateY(0); opacity: 0.4; }
    50% { transform: translateY(-5px); opacity: 1; }
}

.product-card {
    transition: transform 0.2s ease;
    border: 1px solid #e9ecef;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

/* Responsive */
@media (max-width: 768px) {
    .chat-messages {
        height: 300px !important;
    }

    .message-bubble {
        max-width: 90%;
    }

    .quick-suggestions {
        justify-content: center;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatForm = document.getElementById('aiChatForm');
    const chatMessages = document.getElementById('chatMessages');
    const userMessage = document.getElementById('userMessage');
    const sendButton = document.getElementById('sendButton');
    const recommendationsSection = document.getElementById('recommendationsSection');
    const aiRecommendations = document.getElementById('aiRecommendations');

    // Quick suggestion buttons
    document.querySelectorAll('.suggestion-btn').forEach(button => {
        button.addEventListener('click', function() {
            userMessage.value = this.getAttribute('data-message');
            chatForm.dispatchEvent(new Event('submit'));
        });
    });

    // Chat form submission
    chatForm.addEventListener('submit', async function(e) {
        e.preventDefault();

        const message = userMessage.value.trim();
        if (!message) return;

        // Add user message to chat
        addMessageToChat(message, 'user');
        userMessage.value = '';
        sendButton.disabled = true;

        // Show typing indicator
        showTypingIndicator();

        try {
            const response = await fetch('{{ route("ai.get-recommendations") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    message: message,
                    session_id: document.getElementById('sessionId').value
                })
            });

            const data = await response.json();

            // Remove typing indicator
            removeTypingIndicator();

            if (data.success) {
                // Add AI response to chat
                addAIReplyToChat(data.recommendation);

                // Show recommendations
                showProductRecommendations(data.products);
            } else {
                addErrorMessageToChat(data.message);
            }

        } catch (error) {
            console.error('AI Chat Error:', error);
            removeTypingIndicator();
            addErrorMessageToChat('Sorry, something went wrong. Please try again.');
        }

        sendButton.disabled = false;
        userMessage.focus();
    });

    function addMessageToChat(message, type) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `${type}-message mb-3`;

        const avatar = type === 'user' ?
            '<div class="user-avatar ms-3"><i class="fas fa-user fa-sm"></i></div>' :
            '<div class="ai-avatar me-3"><i class="fas fa-robot fa-lg text-primary"></i></div>';

        const bubbleClass = type === 'user' ? 'user-bubble' : 'ai-bubble';
        const alignClass = type === 'user' ? 'justify-content-end' : 'align-items-start';

        messageDiv.innerHTML = `
            <div class="d-flex ${alignClass}">
                ${type !== 'user' ? avatar : ''}
                <div class="message-content ${type === 'user' ? 'text-end' : ''}" style="flex: 1;">
                    <div class="message-bubble ${bubbleClass}">
                        ${message}
                    </div>
                    <small class="text-muted">${new Date().toLocaleTimeString()}</small>
                </div>
                ${type === 'user' ? avatar : ''}
            </div>
        `;

        chatMessages.appendChild(messageDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function addAIReplyToChat(recommendation) {
        let message = `
            <strong>🎯 Based on your requirements:</strong><br><br>
            💰 <strong>Budget Range:</strong> ${recommendation.budget_range || 'Not specified'}<br>
            🏷️ <strong>Recommended Brands:</strong> ${(recommendation.recommended_brands || []).join(', ') || 'All major brands'}<br>
            ⭐ <strong>Key Features:</strong> ${(recommendation.key_features || []).join(', ') || 'Balanced performance'}<br>
            📊 <strong>Best For:</strong> ${recommendation.best_for || 'General use'}<br>
            <br>
            <em>${recommendation.reasoning || 'Here are some great phone options for you!'}</em>
        `;

        addMessageToChat(message, 'ai');
    }

    function showTypingIndicator() {
        const typingDiv = document.createElement('div');
        typingDiv.className = 'ai-message mb-3';
        typingDiv.id = 'typingIndicator';
        typingDiv.innerHTML = `
            <div class="d-flex align-items-start">
                <div class="ai-avatar me-3">
                    <i class="fas fa-robot fa-lg text-primary"></i>
                </div>
                <div class="message-content">
                    <div class="message-bubble ai-bubble">
                        <div class="typing-indicator">
                            <span class="typing-dot"></span>
                            <span class="typing-dot"></span>
                            <span class="typing-dot"></span>
                            <span style="margin-left: 8px; font-size: 0.9em; color: #6c757d;">AI is thinking...</span>
                        </div>
                    </div>
                </div>
            </div>
        `;
        chatMessages.appendChild(typingDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function removeTypingIndicator() {
        const typingIndicator = document.getElementById('typingIndicator');
        if (typingIndicator) {
            typingIndicator.remove();
        }
    }

    function addErrorMessageToChat(message) {
        const errorMessage = `❌ ${message}`;
        addMessageToChat(errorMessage, 'ai');
    }

    function showProductRecommendations(products) {
        if (products.length === 0) {
            aiRecommendations.innerHTML = `
                <div class="col-12 text-center py-4">
                    <i class="fas fa-search fa-2x text-muted mb-3"></i>
                    <p class="text-muted">No products found matching your criteria. Try adjusting your requirements.</p>
                </div>
            `;
        } else {
            aiRecommendations.innerHTML = products.map(product => `
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card product-card h-100">
                        <img src="${product.image}"
                             class="card-img-top"
                             alt="${product.name}"
                             style="height: 200px; object-fit: cover; background: #f8f9fa;">
                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title">${product.name}</h6>
                            <div class="mt-auto">
                                <p class="card-text mb-1">
                                    <span class="text-primary fw-bold">৳${typeof product.price === 'number' ? product.price.toLocaleString() : product.price}</span>
                                </p>
                                <p class="card-text mb-2">
                                    <small class="text-muted">${product.brand}</small>
                                </p>
                                <a href="${product.url}" class="btn btn-primary btn-sm w-100">
                                    <i class="fas fa-eye me-1"></i> View Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        recommendationsSection.classList.remove('d-none');
        recommendationsSection.scrollIntoView({ behavior: 'smooth' });
    }

    // Enter key to send message
    userMessage.addEventListener('keypress', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            chatForm.dispatchEvent(new Event('submit'));
        }
    });

    // Auto-focus on input
    userMessage.focus();
});
</script>
@endpush
