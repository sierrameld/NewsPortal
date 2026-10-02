<div class="container" style="min-height:400px;">
<div class="col-md-11">
    <h2>News Edit</h2>
    <?php if (isset($test)): ?>
        <?php $okText = 'Запись изменена.'; $failText = 'Ошибка изменения записи!'; include __DIR__ . '/resultMessage.php'; ?>
        <?php if ($test[0] === false): ?><a href="newsEdit?id=<?= (int)$id ?>">Попробовать снова</a><?php endif; ?>
    <?php else: ?>
    <form method="POST" action="newsEditResult?id=<?= (int)$id ?>" enctype="multipart/form-data">
        <table class="table table-bordered">
            <tr>
                <td>News title</td>
                <td><input type="text" name="title" class="form-control" maxlength="255" required
                           value="<?= htmlspecialchars($detail['title']) ?>"></td>
            </tr>
            <tr>
                <td>News text</td>
                <td><textarea rows="5" name="text" class="form-control" required><?= htmlspecialchars($detail['text']) ?></textarea></td>
            </tr>
            <tr>
                <td>Category</td>
                <td>
                    <select name="idCategory" class="form-control">
                        <?php foreach ($arr as $row): ?>
                            <option value="<?= (int)$row['id'] ?>" <?= (int)$row['id'] === (int)$detail['category_id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>OldPicture</td>
                <td><img src="data:image/jpeg;base64,<?= base64_encode($detail['picture']) ?>" width="150"></td>
            </tr>
            <tr>
                <td>Picture</td>
                <td><input type="file" name="picture" accept="image/*" style="color:black;">
                    <small>Если не выбрать файл, останется старая картинка</small></td>
            </tr>
            <tr>
                <td colspan="2">
                    <button type="submit" class="btn btn-primary" name="save">
                        <span class="glyphicon glyphicon-plus"></span> Изменить
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
