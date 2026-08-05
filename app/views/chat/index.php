<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <div><h5 class="fw-bold mb-0">Internal Chat</h5><small class="text-muted">Direct messages between team members</small></div>
</div>

<style>
    .chat-contacts { max-height: calc(100vh - 230px); overflow-y: auto; }
    .chat-thread  { height: calc(100vh - 330px); overflow-y: auto; background: #f8f9fa; }
    .chat-contact.active { background: rgba(13,110,253,.08); border-left: 3px solid var(--bs-primary); }
    .chat-bubble { max-width: 75%; word-break: break-word; }
    .chat-bubble .chat-msg { white-space: pre-wrap; }
    .min-w-0 { min-width: 0; }
</style>

<div class="row g-3">
    <div class="col-12 col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3"><strong>Contacts</strong></div>
            <ul id="chatContactList" class="list-group list-group-flush chat-contacts">
                <?php foreach ($contacts as $c): ?>
                    <li class="list-group-item px-3 py-3 chat-contact d-flex align-items-center gap-3" data-user-id="<?= $c['id'] ?>" style="cursor:pointer">
                        <?php if ($c['avatar']): ?>
                            <img src="<?= asset('uploads/' . e($c['avatar'])) ?>" class="rounded-circle object-fit-cover flex-shrink-0" width="40" height="40" alt="avatar">
                        <?php else: ?>
                            <span class="rounded-circle bg-primary-subtle text-primary d-inline-flex align-items-center justify-content-center fw-semibold flex-shrink-0" style="width:40px;height:40px"><?= e(strtoupper(substr($c['first_name'], 0, 1) . substr($c['last_name'], 0, 1))) ?></span>
                        <?php endif; ?>
                        <div class="flex-grow-1 min-w-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-semibold text-truncate"><?= e($c['first_name'] . ' ' . $c['last_name']) ?></span>
                                <small class="text-muted text-nowrap ms-2"><?= $c['last_at'] ? format_date($c['last_at'], 'M d, H:i') : '' ?></small>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small text-muted text-truncate"><?= $c['last_message'] ? e($c['last_message']) : 'No messages yet' ?></span>
                                <?php if ((int) $c['unread'] > 0): ?>
                                    <span class="badge rounded-pill bg-primary flex-shrink-0 ms-2"><?= (int) $c['unread'] ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
                <?php if (empty($contacts)): ?>
                    <li class="list-group-item text-center text-muted py-4">No users available.</li>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <div class="col-12 col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 d-flex align-items-center">
                <i class="bi bi-chat-dots me-2 text-primary"></i>
                <span id="chatHeader" class="fw-semibold text-muted">Select a contact to start chatting</span>
            </div>
            <div class="card-body chat-thread p-3" id="chatThread">
                <div class="text-center text-muted py-5"><i class="bi bi-chat-dots fs-2 d-block mb-2"></i>Select a contact to view the conversation</div>
            </div>
            <div class="card-footer bg-white p-3">
                <form id="chatForm" class="d-flex gap-2">
                    <?= csrf_field() ?>
                    <input type="hidden" id="chatReceiver" name="receiver_id" value="">
                    <input type="text" name="message" id="chatMessage" class="form-control" placeholder="Type a message..." autocomplete="off" required maxlength="1000">
                    <button type="submit" class="btn btn-primary text-nowrap"><i class="bi bi-send me-1"></i>Send</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
window.CHAT_MY_ID = <?= (int) $myId ?>;
window.CHAT_CONTACTS = <?= json_encode($contacts) ?>;
</script>

<?php $scripts[] = <<<'JS'
<script>
$(function(){
    const csrf = $('meta[name="csrf-token"]').attr('content');
    const MY_ID = window.CHAT_MY_ID;
    let contactsCache = window.CHAT_CONTACTS || [];
    let activeChat = null;

    function formatTime(s){
        if (!s) return '';
        const d = new Date(s.replace(' ', 'T'));
        if (isNaN(d.getTime())) return s;
        return d.toLocaleString(undefined, { month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' });
    }

    function contactById(id){
        for (let i = 0; i < contactsCache.length; i++) {
            if (String(contactsCache[i].id) === String(id)) return contactsCache[i];
        }
        return null;
    }

    function avatarHtml(c){
        if (c.avatar) {
            return '<img src="' + EMS_BASE + '/assets/uploads/' + c.avatar + '" class="rounded-circle object-fit-cover flex-shrink-0" width="40" height="40" alt="avatar">';
        }
        const initials = (c.first_name.charAt(0) + c.last_name.charAt(0)).toUpperCase();
        return '<span class="rounded-circle bg-primary-subtle text-primary d-inline-flex align-items-center justify-content-center fw-semibold flex-shrink-0" style="width:40px;height:40px">' + initials + '</span>';
    }

    function renderContacts(list){
        contactsCache = list;
        const $ul = $('#chatContactList');
        $ul.empty();
        if (!list.length) {
            $ul.append('<li class="list-group-item text-center text-muted py-4">No users available.</li>');
            return;
        }
        list.forEach(function(c){
            const isActive = activeChat !== null && String(c.id) === String(activeChat);
            const $li = $('<li>').addClass('list-group-item px-3 py-3 chat-contact d-flex align-items-center gap-3' + (isActive ? ' active' : ''))
                .attr('data-user-id', c.id).css('cursor', 'pointer');
            const $body = $('<div>').addClass('flex-grow-1 min-w-0');
            const $top = $('<div>').addClass('d-flex justify-content-between align-items-center');
            $top.append($('<span>').addClass('fw-semibold text-truncate').text(c.first_name + ' ' + c.last_name));
            $top.append($('<small>').addClass('text-muted text-nowrap ms-2').text(c.last_at ? formatTime(c.last_at) : ''));
            const $bottom = $('<div>').addClass('d-flex justify-content-between align-items-center');
            $bottom.append($('<span>').addClass('small text-muted text-truncate').text(c.last_message || 'No messages yet'));
            if (parseInt(c.unread, 10) > 0 && !isActive) {
                $bottom.append($('<span>').addClass('badge rounded-pill bg-primary flex-shrink-0 ms-2').text(c.unread));
            }
            $body.append($top, $bottom);
            $li.append(avatarHtml(c), $body);
            $ul.append($li);
        });
    }

    function renderMessages(data){
        const $t = $('#chatThread');
        $t.empty();
        if (!data.messages.length) {
            $t.append('<div class="text-center text-muted py-5">No messages yet. Say hi!</div>');
            return;
        }
        data.messages.forEach(function(m){
            const mine = String(m.sender_id) === String(MY_ID);
            const $row = $('<div>').addClass('d-flex mb-3 ' + (mine ? 'justify-content-end' : 'justify-content-start'));
            const $bubble = $('<div>').addClass('chat-bubble p-3 rounded-3 ' + (mine ? 'bg-primary text-white' : 'bg-light'));
            if (!mine) {
                $bubble.append($('<div>').addClass('small fw-semibold mb-1').text(m.first_name + ' ' + m.last_name));
            }
            $bubble.append($('<div>').addClass('chat-msg').text(m.message));
            $bubble.append($('<div>').addClass('small ' + (mine ? 'text-white-50' : 'text-muted') + ' mt-1').text(formatTime(m.created_at)));
            $row.append($bubble);
            $t.append($row);
        });
        $t.scrollTop($t[0].scrollHeight);
    }

    function loadThread(id, silent){
        $.getJSON(EMS_BASE + '/chat/messages/' + id, function(r){
            if (r.success) {
                renderMessages(r);
                renderContacts(contactsCache);
            }
        }).fail(function(){
            if (!silent) toast('Could not load messages.', 'error');
        });
    }

    function openChat(id){
        activeChat = id;
        $('#chatReceiver').val(id);
        const c = contactById(id);
        $('#chatHeader').text(c ? ('Chatting with ' + c.first_name + ' ' + c.last_name) : 'Internal Chat');
        renderContacts(contactsCache);
        loadThread(id);
    }

    $(document).on('click', '.chat-contact', function(){
        openChat($(this).data('user-id'));
    });

    $('#chatForm').on('submit', function(e){
        e.preventDefault();
        if (activeChat === null) {
            toast('Select a contact first.', 'warning');
            return;
        }
        const msg = $.trim($('#chatMessage').val());
        if (!msg) return;
        $.ajax({
            url: EMS_BASE + '/chat/send', method: 'POST', dataType: 'json',
            data: $(this).serialize(), headers: { 'X-CSRF-TOKEN': csrf },
            success: function(r){
                if (r.success) {
                    $('#chatMessage').val('');
                    loadThread(activeChat, true);
                } else {
                    toast(r.message, 'error');
                }
            },
            error: function(xhr){
                try { toast(JSON.parse(xhr.responseText).message, 'error'); }
                catch (x) { toast('Error sending message.', 'error'); }
            }
        });
    });

    setInterval(function(){ refreshContacts(); }, 5000);
    setInterval(function(){ if (activeChat !== null) loadThread(activeChat, true); }, 4000);

    function refreshContacts(){
        $.getJSON(EMS_BASE + '/chat/contacts', function(r){
            if (r.success) renderContacts(r.contacts);
        });
    }
});
</script>
JS;
?>
