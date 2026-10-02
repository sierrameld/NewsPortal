<div class="container" style="min-height:400px;">
<div class="col-md-11">
    <h2>News Add</h2>
    <?php if (isset($test)): ?>
        <?php $okText = 'Запись добавлена.'; $failText = 'Ошибка добавления записи!'; include __DIR__ . '/resultMessage.php'; ?>
        <?php if ($test[0] === false): ?><a href="newsAdd">Попробовать снова</a><?php endif; ?>
    <?php else: ?>
    <form method="POST" action="newsAddResult" enctype="multipart/form-data">
        <table class="table table-bordered">
            <tr>
                <td>News title</td>
                <td><input type="text" name="title" class="form-control" maxlength="255" required></td>
            </tr>
            <tr>
                <td>News text</td>
                <td><textarea rows="5" name="text" class="form-control" required></textarea></td>
            </tr>
            <tr>
                <td>Category</td>
                <td>
                    <select name="idCategory" class="form-control">
                        <?php foreach ($arr as $row): ?>
                            <option value="<?= (int)$row['id'] ?>"><?= htmlspecialchars($row['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Picture</td>
                <td><input type="file" name="picture" accept="image/*" style="color:black;" required></td>
            </tr>
            <tr>
                <td colspan="2">
                    <button type="submit" class="btn btn-primary" name="save">
                        <span class="glyphicon glyphicon-plus"></span> Сохранить
                    </button>
                    <a href="newsAdmin" class="btn btn-large btn-success">
                        <i class="glyphicon glyphicon-backward"></i> &nbsp;Назад к списку
                    </a>
                </td>
            </tr>
        </table>
    </form>
    <?php endif; ?>
</div>
</div>
