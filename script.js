/**
 * Billing Management System - Frontend Controller
 * Handles all user interactions and data loading
 */

// Configuration
const CONFIG = {
    apiBaseUrl: '', // Consider adding a default API base URL
    currentUserId: 1,
    defaultPlan: 'basic',
    plans: {
        basic: {
            name: "Basic Website Package",
            price: 49,
            features: [
                "5 Page Website",
                "Mobile Responsive",
                "Basic SEO",
                "Contact Form"
            ]
        },
        professional: {
            name: "Professional Website Package",
            price: 99,
            features: [
                "10 Page Website",
                "Mobile Responsive",
                "Advanced SEO",
                "CMS Integration"
            ]
        },
        premium: {
            name: "Premium Website Package",
            price: 199,
            features: [
                "Unlimited Pages",
                "Mobile Responsive",
                "Advanced SEO",
                "E-commerce Functionality",
                "Priority Support"
            ]
        }
    }
};

// DOM Elements - improved null checks and element selection
const elements = {
    get user_id() { return document.getElementById('user_id'); },
    get planName() { return document.getElementById('plan-name'); },
    get planPrice() { return document.getElementById('plan-price'); },
    get planStatus() { return document.getElementById('plan-status'); },
    get planFeatures() { return document.getElementById('plan-features'); },
    get billingTableBody() { return document.getElementById('billing-table-body'); },
    get paymentCardsContainer() { return document.getElementById('payment-cards'); },
    modals: {
        get upgrade() { return document.getElementById('upgrade-modal'); },
        get cancel() { return document.getElementById('cancel-modal'); },
        get payment() { return document.getElementById('payment-modal'); }
    },
    buttons: {
        get upgrade() { return document.getElementById('upgrade-plan'); },
        get cancel() { return document.getElementById('cancel-plan'); },
        get addCard() { return document.getElementById('add-card'); }
    }
};

// State Management
const appState = {
    currentUser: null,
    billingHistory: [],
    paymentMethods: []
};

// Initialize Application
document.addEventListener('DOMContentLoaded', async () => {
    try {
        await initializeApp();
        setupEventListeners();
        setupMobileMenu(); // Extracted mobile menu setup to separate function
    } catch (error) {
        handleFatalError(error);
    }
});

// Core Functions
async function initializeApp() {
    showLoadingState();
    try {
        await loadUserData();
        updateUI();
    } finally {
        hideLoadingState();
    }
}



// Data Fetching Utilities
async function fetchData(url, options = {}) {
    try {
        const fullUrl = CONFIG.apiBaseUrl ? `${CONFIG.apiBaseUrl}${url}` : url;
        const response = await fetch(fullUrl, options);
        
        if (!response.ok) {
            const errorData = await parseResponse(response);
            throw new Error(errorData.error || `HTTP error! status: ${response.status}`);
        }
        
        return await parseResponse(response);
    } catch (error) {
        console.error('Fetch error:', error);
        throw error;
    }
}

async function parseResponse(response) {
    const contentType = response.headers.get('content-type');
    if (!contentType || !contentType.includes('application/json')) {
        throw new Error('Received non-JSON response');
    }
    
    try {
        return await response.json();
    } catch (error) {
        console.error('Failed to parse JSON:', error);
        throw new Error('Invalid server response format');
    }
}

// UI Update Functions
function updateUI() {
    if (!appState.currentUser) return;
    
    updateUserProfile();
    updatePlanInformation();
    renderBillingHistory();
    renderPaymentMethods();
}

function updateUserProfile() {
    const { currentUser } = appState;
    if (!elements.userAvatar || !currentUser) return;
    
    const firstNameInitial = currentUser.first_name?.[0] || '';
    const lastNameInitial = currentUser.last_name?.[0] || '';
    elements.userAvatar.textContent = `${firstNameInitial}${lastNameInitial}`.toUpperCase();
}

function updatePlanInformation() {
    const { currentUser } = appState;
    if (!currentUser || !elements.planName || !elements.planPrice || !elements.planStatus || !elements.planFeatures) return;
    
    const planKey = currentUser.plan || CONFIG.defaultPlan;
    const plan = CONFIG.plans[planKey];
    if (!plan) return;
    
    elements.planName.textContent = plan.name;
    
    const price = currentUser.billing_cycle === 'annual' 
        ? Math.round(plan.price * 12 * 0.85) 
        : plan.price;
    const period = currentUser.billing_cycle === 'annual' ? '/year' : '/month';
    elements.planPrice.innerHTML = `$${price}<span class="month">${period}</span>`;
    
    const billingDate = new Date(currentUser.billing_date || new Date());
    elements.planStatus.textContent = `Active • Renews on ${billingDate.toLocaleDateString()}`;
    
    elements.planFeatures.innerHTML = plan.features
        .map(feature => `<li><i class="fas fa-check"></i> ${feature}</li>`)
        .join('');
}

function renderBillingHistory() {
    if (!elements.billingTableBody) return;
    
    const { billingHistory } = appState;
    
    if (!billingHistory || billingHistory.length === 0) {
        elements.billingTableBody.innerHTML = '<tr><td colspan="5">No billing records found</td></tr>';
        return;
    }
    
    elements.billingTableBody.innerHTML = billingHistory.map(item => {
        const date = new Date(item.transaction_date);
        const statusClass = `status-${item.status?.toLowerCase() || 'unknown'}`;
        const amount = typeof item.amount === 'number' ? item.amount.toFixed(2) : '0.00';
        
        return `
            <tr>
                <td>${date.toLocaleDateString()}</td>
                <td>${item.description || 'No description'}</td>
                <td>$${amount}</td>
                <td><span class="status ${statusClass}">${item.status || 'Unknown'}</span></td>
                <td><a href="#" class="invoice-link">${item.invoice_number || 'N/A'}</a></td>
            </tr>
        `;
    }).join('');
}

function renderPaymentMethods() {
    if (!elements.paymentCardsContainer) return;
    
    const { paymentMethods } = appState;
    elements.paymentCardsContainer.innerHTML = '';
    
    if (!paymentMethods || paymentMethods.length === 0) {
        elements.paymentCardsContainer.innerHTML = '<p class="no-cards">No payment methods on file</p>';
    } else {
        paymentMethods.forEach(method => {
            const cardElement = document.createElement('div');
            cardElement.className = `payment-card ${method.is_default ? 'card-default' : ''}`;
            cardElement.innerHTML = `
                <div class="card-type">
                    <span>${method.card_type?.toUpperCase() || 'CARD'}</span>
                    ${method.is_default ? '<span class="default-badge">DEFAULT</span>' : ''}
                </div>
                <div class="card-number">•••• •••• •••• ${method.last4 || '0000'}</div>
                <div class="card-expiry">Expires ${method.exp_month || 'MM'}/${method.exp_year || 'YY'}</div>
                <div class="card-actions">
                    <button class="btn btn-sm btn-outline edit-card">Edit</button>
                    <button class="btn btn-sm btn-danger remove-card">Remove</button>
                </div>
            `;
            elements.paymentCardsContainer.appendChild(cardElement);
        });
    }
    
    // Add "Add Card" button if it exists
    if (elements.buttons.addCard) {
        elements.paymentCardsContainer.appendChild(elements.buttons.addCard);
    }
}

// Event Handling
function setupEventListeners() {
    // Modal controls with null checks
    if (elements.buttons.upgrade && elements.modals.upgrade) {
        elements.buttons.upgrade.addEventListener('click', () => toggleModal('upgrade'));
    }
    
    if (elements.buttons.cancel && elements.modals.cancel) {
        elements.buttons.cancel.addEventListener('click', () => toggleModal('cancel'));
    }
    
    if (elements.buttons.addCard && elements.modals.payment) {
        elements.buttons.addCard.addEventListener('click', () => toggleModal('payment'));
    }
    
    // Close modals when clicking outside content
    Object.entries(elements.modals).forEach(([key, modal]) => {
        if (modal) {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) toggleModal(key);
            });
        }
    });
    
    // Form submissions with null checks
    const upgradeForm = document.getElementById('upgrade-form');
    if (upgradeForm) upgradeForm.addEventListener('submit', handlePlanUpgrade);
    
    const cancelForm = document.getElementById('cancel-form');
    if (cancelForm) cancelForm.addEventListener('submit', handlePlanCancellation);
    
    const paymentForm = document.getElementById('payment-form');
    if (paymentForm) paymentForm.addEventListener('submit', handlePaymentMethodAdd);
    
    // Plan selection handling
    document.querySelectorAll('.select-plan').forEach(button => {
        button.addEventListener('click', handlePlanSelection);
    });
}

function setupMobileMenu() {
    const menu = document.querySelector('#mobile-menu');
    const menuLinks = document.querySelector('.navbar__menu');
    
    if (menu && menuLinks) {
        menu.addEventListener('click', function() {
            menu.classList.toggle('is-active');
            menuLinks.classList.toggle('active');
        });
    }
}

function toggleModal(modalName) {
    const modal = elements.modals[modalName];
    if (modal) {
        modal.style.display = modal.style.display === 'flex' ? 'none' : 'flex';
    }
}

function handlePlanSelection() {
    const plan = this.getAttribute('data-plan');
    const planData = getPlanData(plan);
    
    if (!planData) return;
    
    // Update payment modal fields
    const planInput = document.getElementById('plan');
    const amountInput = document.getElementById('amount');
    const planTypeInput = document.getElementById('plan-type');
    const planAmountInput = document.getElementById('plan-amount');
    
    if (planInput) planInput.value = planData.name;
    if (amountInput) amountInput.value = `£${planData.amount}`;
    if (planTypeInput) planTypeInput.value = plan;
    if (planAmountInput) planAmountInput.value = planData.amount;
    
    // Update PayPal form fields if they exist
    const paypalItemName = document.getElementById('paypal-item-name');
    const paypalAmount = document.getElementById('paypal-amount');
    const paypalCustom = document.getElementById('paypal-custom');
    
    if (paypalItemName) paypalItemName.value = planData.name;
    if (paypalAmount) paypalAmount.value = planData.amount;
    if (paypalCustom) {
        paypalCustom.value = JSON.stringify({
            plan_type: plan,
            plan_name: planData.name,
            amount: planData.amount
        });
    }
    
    // Show the payment modal
    if (elements.modals.payment) {
        elements.modals.payment.style.display = 'block';
    }
}

function getPlanData(plan) {
    switch(plan) {
        case 'basic':
            return { name: 'Basic Plan', amount: '199' };
        case 'professional':
            return { name: 'Professional Plan', amount: '499' };
        case 'premium':
            return { name: 'Premium Plan', amount: '899' };
        default:
            console.warn(`Unknown plan type: ${plan}`);
            return null;
    }
}

async function handlePlanUpgrade(e) {
    e.preventDefault();
    showLoadingState();
    try {
        // Implementation would go here
        // await performPlanUpgrade();
        // await loadUserData();
        // updateUI();
    } catch (error) {
        showErrorToUser('Failed to upgrade plan. Please try again.');
        console.error('Plan upgrade error:', error);
    } finally {
        hideLoadingState();
    }
}

async function handlePlanCancellation(e) {
    e.preventDefault();
    showLoadingState();
    try {
        // Implementation would go here
    } catch (error) {
        showErrorToUser('Failed to cancel plan. Please try again.');
        console.error('Plan cancellation error:', error);
    } finally {
        hideLoadingState();
    }
}

async function handlePaymentMethodAdd(e) {
    e.preventDefault();
    showLoadingState();
    try {
        // Implementation would go here
    } catch (error) {
        showErrorToUser('Failed to add payment method. Please try again.');
        console.error('Payment method add error:', error);
    } finally {
        hideLoadingState();
    }
}

// Utility Functions
function showLoadingState() {
    document.body.classList.add('loading');
}

function hideLoadingState() {
    document.body.classList.remove('loading');
}

function showErrorToUser(message) {
    const existingError = document.querySelector('.global-error');
    if (existingError) existingError.remove();
    
    const errorElement = document.createElement('div');
    errorElement.className = 'global-error';
    errorElement.innerHTML = `
        <div class="error-content">
            <span class="close-error">&times;</span>
            <p>${message}</p>
        </div>
    `;
    document.body.appendChild(errorElement);
    
    errorElement.querySelector('.close-error').addEventListener('click', () => {
        errorElement.remove();
    });
}



// Public API
window.app = {
    refreshData: loadUserData,
    getState: () => ({ ...appState }) // Return a shallow copy to prevent direct state modification
};

// scripts.js (or inline before </body>)
document.addEventListener('DOMContentLoaded', function() {
  // Grab all "Select Plan" buttons
  const planButtons = document.querySelectorAll('.select-plan');
  const planSelect  = document.getElementById('plan-type');
  const contactFormSection = document.getElementById('contact');

  planButtons.forEach(btn => {
    btn.addEventListener('click', function(e) {
      e.preventDefault();
      const chosenPlan = this.getAttribute('data-plan');

      // If the dropdown has an option with this value, select it
      if (planSelect) {
        const optExists = Array.from(planSelect.options).some(o => o.value === chosenPlan);
        if (optExists) {
          planSelect.value = chosenPlan;
        }
      }

      // Scroll down to the contact form
      if (contactFormSection) {
        contactFormSection.scrollIntoView({ behavior: 'smooth' });
      }
    });
  });
});

document.addEventListener('DOMContentLoaded', function () {
  const mobileMenu = document.getElementById('mobile-menu');
  const navbarMenu = document.querySelector('.navbar__menu');

  mobileMenu.addEventListener('click', function () {
    mobileMenu.classList.toggle('is-active');
    navbarMenu.classList.toggle('active');
  });
});
