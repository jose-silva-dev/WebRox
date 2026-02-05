<h3 class="subtitle">Configurações de E-mail</h3>
<small style="color: #999; font-size: 12px; display: block; margin-bottom: 15px;">
    Configure o servidor SMTP para envio de e-mails (recuperação de senha, notificações, etc.)
</small>
<div class="grid-2">
    <div>
        <label>Host SMTP</label>
        <input type="text" name="mail_host" value="<?= htmlspecialchars($mail['host']) ?>" >
        <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">Endereço do servidor SMTP (ex: smtp.gmail.com, smtp.outlook.com)</small>
    </div>
    <div>
        <label>Porta SMTP</label>
        <input type="number" name="mail_port" value="<?= (int)$mail['port'] ?>" >
        <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">Porta do servidor SMTP (587 para TLS, 465 para SSL, 25 para não criptografado)</small>
    </div>
    <div>
        <label>Usuário SMTP</label>
        <input type="text" name="mail_username" value="<?= htmlspecialchars($mail['username']) ?>" >
        <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">E-mail ou usuário para autenticação no servidor SMTP</small>
    </div>
    <div>
        <label>Senha SMTP</label>
        <input type="password" name="mail_password" value="<?= htmlspecialchars($mail['password']) ?>">
        <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">Senha do e-mail ou senha de aplicativo (Gmail requer senha de app)</small>
    </div>
    <div style="grid-column: span 2">
        <label>E-mail Remetente</label>
        <input type="email" name="mail_email" value="<?= htmlspecialchars($mail['email']) ?>" >
        <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">E-mail que aparecerá como remetente nas mensagens enviadas</small>
    </div>
</div>
