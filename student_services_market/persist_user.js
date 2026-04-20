document.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const userId = urlParams.get('user_id');

    if (!userId) {
        const authPages = ['post_service.html', 'browse_services.html'];
        const currentPage = window.location.pathname.split('/').pop() || '';
        if (authPages.includes(currentPage)) {
            let authDiv = document.getElementById('auth-container');
            if (!authDiv) {
                authDiv = document.createElement('div');
                authDiv.id = 'auth-container';
                authDiv.className = 'auth-message';
                const h1 = document.querySelector('h1');
                if (h1) h1.after(authDiv);
                else document.body.prepend(authDiv);
            }
            authDiv.textContent = 'Failed to authenticate, please log in.';
            authDiv.style.display = 'block';
        }
    }

    if (userId) {
        // Update all links pointing to the same server
        document.querySelectorAll('a').forEach(link => {
            if (link.href && link.href.startsWith(window.location.origin)) {
                try {
                    const url = new URL(link.href);
                    url.searchParams.set('user_id', userId);
                    link.href = url.toString();
                } catch (e) {
                    console.error("Error modifying link:", e);
                }
            }
        });

        // Update forms to submit the user_id
        document.querySelectorAll('form').forEach(form => {
            // Add as persistent query parameter on the action URL
            if (form.action && form.action.startsWith(window.location.origin)) {
                try {
                    const actionUrl = new URL(form.action);
                    actionUrl.searchParams.set('user_id', userId);
                    form.action = actionUrl.toString();
                } catch (e) {}
            }
            
            // Also append a hidden input so POST requests receive it
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'user_id';
            input.value = userId;
            form.appendChild(input);
        });
    }

    // Global Error and Notification Message rendering mapping to query parameters
    const errorMsg = urlParams.get('error');
    if (errorMsg) {
        let errDiv = document.getElementById('error-container');
        if (!errDiv) {
            errDiv = document.createElement('div');
            errDiv.id = 'error-container';
            errDiv.className = 'error-message';
            const h1 = document.querySelector('h1');
            if (h1) h1.after(errDiv);
            else document.body.prepend(errDiv);
        }
        errDiv.textContent = errorMsg;
        errDiv.style.display = 'block';
    }

    const msgTxt = urlParams.get('msg');
    if (msgTxt) {
        let msgDiv = document.getElementById('msg-container');
        if (!msgDiv) {
            msgDiv = document.createElement('div');
            msgDiv.id = 'msg-container';
            msgDiv.className = 'msg-message';
            const h1 = document.querySelector('h1');
            if (h1) h1.after(msgDiv);
            else document.body.prepend(msgDiv);
        }
        msgDiv.textContent = msgTxt;
        msgDiv.style.display = 'block';
    }
});
