// Sistema de Notificações (Toast)
class Notification {
  static show(message, type = 'success') {
    // Remove notificações existentes
    const existing = document.querySelector('.notification-toast');
    if (existing) {
      existing.remove();
    }

    // Cria elemento de notificação
    const notification = document.createElement('div');
    notification.className = `notification-toast notification-${type}`;
    notification.innerHTML = `
      <div class="notification-content">
        <span class="notification-message">${message}</span>
        <button class="notification-close" onclick="this.parentElement.parentElement.remove()">&times;</button>
      </div>
    `;

    // Adiciona ao body
    document.body.appendChild(notification);

    // Anima entrada
    setTimeout(() => {
      notification.classList.add('show');
    }, 10);

    // Remove automaticamente após 4 segundos
    setTimeout(() => {
      notification.classList.remove('show');
      setTimeout(() => {
        if (notification.parentElement) {
          notification.remove();
        }
      }, 300);
    }, 4000);
  }

  static success(message) {
    this.show(message, 'success');
  }

  static error(message) {
    this.show(message, 'error');
  }

  static info(message) {
    this.show(message, 'info');
  }

  static warning(message) {
    this.show(message, 'warning');
  }
}

