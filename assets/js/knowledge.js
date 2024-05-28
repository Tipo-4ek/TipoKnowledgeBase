$('.autoExpand').each(function() {
    var maxHeight = 300;
    this.setAttribute('style', 'resize:none; height:' + (this.scrollHeight > maxHeight ? maxHeight : this.scrollHeight) + 'px;overflow-y:' + (this.scrollHeight > maxHeight ? 'auto' : 'hidden') + ';');
}).on('input', function() {
    var maxHeight = 300;
    this.style.height = 'auto';
    this.style.height = (this.scrollHeight > maxHeight ? maxHeight : this.scrollHeight) + 'px';
    this.style.overflowY = (this.scrollHeight > maxHeight ? 'auto' : 'hidden');
});

document.getElementById('validateKnowledge').addEventListener('click', function() {
    // Извлекаем параметр id из URL
    const urlParams = new URLSearchParams(window.location.search);
    const knowledgeId = urlParams.get('id');

    fetch('/assets/php/validate-knowledge.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'knowledgeId=' + knowledgeId
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log(data.message);
            // Тут можно добавить код для обновления UI, например, сообщение об успешной операции
        } else {
            console.error(data.message);
            // Сообщение об ошибке
        }
    })
    .catch(error => console.error('Error:', error));
});