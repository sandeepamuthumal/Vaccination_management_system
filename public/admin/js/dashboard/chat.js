$('.type-massage .form-control').on('keydown', function(event) {
    if (event.key === 'Enter') {
        var chatInput = $(this);
        var chatMessageValue = chatInput.val();
        if (chatMessageValue === '') { return; }
        $messageHtml = '<div class="media mb-4 justify-content-end align-items-end">' +
            '<div class="message-sent">' +
            '<p class="mb-1">' +
            chatMessageValue +
            '</p>' +
            '<span class="fs-12 text-black">9.30 AM</span>' +
            '</div>' +
            '<div class="image-bx ms-sm-3 ms-2 mb-4">' +
            '<img src="images/profile/pic1.jpg" alt="" class="rounded-circle img-1">' +
            '</div>' +
            '</div>';
        var appendMessage = $(this).parents().find('.active-chat').append($messageHtml);
        const getScrollContainer = document.querySelector('.chat-box-area');
        getScrollContainer.scrollTop = getScrollContainer.scrollHeight;
        var clearChatInput = chatInput.val('');

    }
});