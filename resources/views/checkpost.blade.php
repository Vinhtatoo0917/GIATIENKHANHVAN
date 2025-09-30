<form method="POST">
    <div class="form-group">
        <label for="username">👤 Tên đăng nhập:</label>
        <input
            type="text"
            id="username"
            name="username"
            placeholder="Nhập tên đăng nhập..."
            autocomplete="username">
    </div>

    <div class="form-group">
        <label for="password">🔒 Mật khẩu:</label>
        <input
            type="password"
            id="password"
            name="password"
            placeholder="Nhập mật khẩu..."
            autocomplete="current-password">
    </div>
    <input type="hidden" name="_method" value="PUT">
    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

    <button type="submit" class="btn-login">Đăng Nhập</button>
</form>