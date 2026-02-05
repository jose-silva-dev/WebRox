<h3 class="subtitle">Termos de Uso e Regras do Jogo</h3>
<small style="color: #999; font-size: 12px; display: block; margin-bottom: 15px;">
    Configure o conteúdo dos termos de uso e regras do jogo que aparecem no formulário de cadastro
</small>
<div>
    <label>Termos de Uso</label>
    <textarea name="terms[content]" id="terms-content" rows="15" style="width: 100%; padding: 12px; background: var(--background-card); border: 1px solid var(--neutral-300); border-radius: 8px; color: var(--white); font-family: 'Space Grotesk', sans-serif; font-size: 14px; resize: vertical;" ><?= htmlspecialchars(is_string($terms['content'] ?? '') ? $terms['content'] : '') ?></textarea>
    <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">Conteúdo dos termos de uso exibido na página de termos</small>
</div>
<div>
    <label>Regras do Jogo</label>
    <textarea name="rules[content]" id="rules-content" rows="15" style="width: 100%; padding: 12px; background: var(--background-card); border: 1px solid var(--neutral-300); border-radius: 8px; color: var(--white); font-family: 'Space Grotesk', sans-serif; font-size: 14px; resize: vertical;" ><?= htmlspecialchars(is_string($rules['content'] ?? '') ? $rules['content'] : '') ?></textarea>
    <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">Conteúdo das regras do jogo exibido na página de regras</small>
</div>
<div style="background: #2a2a2a; padding: 12px; border-radius: 6px; margin-top: 15px;">
    <strong style="color: #fff; display: block; margin-bottom: 8px;">ℹ️ Informações:</strong>
    <ul style="color: #ccc; font-size: 13px; margin: 0; padding-left: 20px;">
        <li>O conteúdo será exibido nas páginas de termos e regras</li>
        <li>Você pode usar HTML para formatar o texto</li>
        <li>Os links aparecem no formulário de cadastro e abrem em nova aba</li>
    </ul>
</div>
