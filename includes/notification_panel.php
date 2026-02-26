<!-- Notification Panel -->
<div id="notification-panel" class="notification-panel">
    <div class="notification-header">
        <h3>Notifications</h3>
        <span class="close-panel" onclick="closeNotificationPanel()">&times;</span>
    </div>
    <div id="notification-list" class="notification-list">
        <!-- Notifications will be loaded here -->
    </div>
</div>

<style>
.notification-panel {
    position: fixed;
    top: 0;
    right: -400px;
    width: 350px;
    height: 100%;
    background: white;
    box-shadow: -2px 0 5px rgba(0,0,0,0.1);
    transition: right 0.3s;
    z-index: 1000;
    border-left: 1px solid #ddd;
}
.notification-panel.open {
    right: 0;
}
.notification-header {
    background: #228B22;
    color: white;
    padding: 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.notification-header h3 {
    margin: 0;
}
.notification-header .close-panel {
    cursor: pointer;
    font-size: 24px;
}
.notification-list {
    padding: 10px;
    max-height: calc(100% - 60px);
    overflow-y: auto;
}
.notification-item {
    background: #f8f9fa;
    margin: 10px 0;
    padding: 10px;
    border-radius: 5px;
    border-left: 4px solid #228B22;
    cursor: pointer;
    transition: background 0.3s;
}
.notification-item.unread {
    background: #e8f5e9;
}
.notification-item.expanded {
    background: #fff;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}
.notification-item .summary {
    font-weight: bold;
}
.notification-item .details {
    display: none;
    margin-top: 10px;
    padding-top: 10px;
    border-top: 1px solid #ddd;
}
.notification-item.expanded .details {
    display: block;
}
.notification-item .time {
    font-size: 12px;
    color: #666;
}
.menu-icon-notifications {
    background-image: url('../img/icons/session.svg');
    cursor: pointer;
}
.menu-icon-notifications:hover {
    background-image: url('../img/icons/session-iceblue.svg');
}
</style>

<script>
function openNotificationPanel() {
    document.getElementById('notification-panel').classList.add('open');
    loadNotifications();
}

function closeNotificationPanel() {
    document.getElementById('notification-panel').classList.remove('open');
}

function loadNotifications() {
    fetch('../get_notifications.php')
        .then(response => response.json())
        .then(data => {
            const list = document.getElementById('notification-list');
            list.innerHTML = '';
            if (data.length === 0) {
                list.innerHTML = '<p style="text-align:center;color:#888;padding:20px;">No notifications.</p>';
            } else {
                data.forEach(notification => {
                    const item = document.createElement('div');
                    item.className = 'notification-item' + (notification.is_read == 0 ? ' unread' : '');
                    const summary = notification.message.length > 50 ? notification.message.substring(0, 50) + '...' : notification.message;
                    const details = notification.type === 'review' ? `<strong>Full Review:</strong><br>${notification.message}` : notification.message;
                    item.innerHTML = `
                        <div class="summary">${summary}</div>
                        <div class="details">${details}</div>
                        <div class="time">${new Date(notification.created_at).toLocaleString()}</div>
                    `;
                    item.onclick = () => {
                        item.classList.toggle('expanded');
                        if (notification.is_read == 0) {
                            markAsRead(notification.id);
                            item.classList.remove('unread');
                            notification.is_read = 1;
                        }
                    };
                    list.appendChild(item);
                });
            }
        })
        .catch(error => console.error('Error loading notifications:', error));
}

function markAsRead(id) {
    fetch('../mark_read.php?id=' + id, { method: 'POST' });
}

// Add click event to notification button
document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('notification-btn');
    if (btn) {
        btn.addEventListener('click', openNotificationPanel);
    }
});
</script>
