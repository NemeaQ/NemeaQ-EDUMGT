<div class="loginPage mx-auto"><h1 class="mb-4">Настройки</h1>
    <form action="/profile" method="post">
        <div class="form-group">
            <label for="sname">Фамилия</label>
            <input type="text" class="form-control" id="sname" name="sname"
                   value="<?php echo $_SESSION['account']['sname']; ?>" required>
        </div>
        <div class="form-group">
            <label for="fname">Имя</label>
            <input type="text" class="form-control" id="fname" name="fname"
                   value="<?php echo $_SESSION['account']['fname']; ?>" required>
        </div>
        <div class="form-group">
            <label for="mname">Отчество</label>
            <input type="text" class="form-control" id="mname" name="mname"
                   value="<?php echo $_SESSION['account']['mname']; ?>" required>
        </div>
        <div class="form-group">
            <label for="email">E-mail</label>
            <input type="email" class="form-control" id="email" name="email"
                   value="<?php echo $_SESSION['account']['email']; ?>" required>
        </div>

        <div class="form-group">
            <label for="file">Фото профиля</label>
            <input type="file" class="form-control" id="file" name="photo">
        </div>

        <div class="form-group">
            <label for="experience">Стаж</label>
            <input type="text" class="form-control" id="experience"
                   value="<?php echo $_SESSION['account']['teachers']['exp']; ?>" required name="experience">
        </div>

        <div class="form-group">
            <label for="skill">Квалификация</label>
            <select class="custom-select" id="skill" required name="skill">
                <?php foreach ($skill as $index => $value): ?>
                    <option <?php if ($_SESSION['account']['skill'] == $index + 1) echo 'selected'; ?>><?= $value ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <hr>
        <div class="control-group form-group">
            <div class="controls">
                <label>Новый пароль для входа (если хотите изменить):</label>
                <input type="password" class="form-control" name="password">
            </div>
        </div>
        <button type="submit" class="btn btn-accent">Сохранить</button>
    </form>
</div>


<style>
    body {
        background-color: #fff !important;
    }

    .loginPage {
        text-align: center;
        max-width: 480px;
    }

    h1 {
        color: #797CD5;
    }
</style>
