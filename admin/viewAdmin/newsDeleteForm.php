<div class="container" style="min-height:400px;">
<div class="col-md-11">
    <h2>News delete</h2>
    <?php if (isset($test)): ?>
        <?php $okText = 'Запись удалена.'; $failText = 'Ошибка удаления записи!'; include __DIR__ . '/resultMessage.php'; ?>
    <?php else: ?>
    <form method="POST" action="newsDelResult?id=<?= (int)$id ?>">
        <table class="table table-bordered">
            <tr>
                <td>News title</td>
                <td><input type="text" class="form-control" readonly value="<?= htmlspecialchars($detail['title']) ?>"></td>
            </tr>
            <tr>
                <td>News text</td>
                <td><textarea rows="5" class="form-control" readonly><?= htmlspecialchars($detail['text']) ?></textarea></td>
            </tr>
            <tr>
                <td>Category</td>
                <td>
                    <select class="form-control" disabled>
                        <?php foreach ($arr as $row): ?>
                            <option <?= (int)$row['id'] === (int)$detail['category_id'] ? 'selected' : '' ?>><?= htmlspecialchars($row['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>OldPicture</td>
                <td><img src="data:image/jpeg;base64,<?= base64_encode($detail['picture']) ?>" width="150"></td>
            </tr>
            <tr>
                <td colspan="2">
                    <p>Вместе с новостью удалятся и все её комментарии.</p>
                    <button type="submit" class="btn btn-primary" name="save">
                        <span class="glyphicon glyphicon-remove"></span> Удалить
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
