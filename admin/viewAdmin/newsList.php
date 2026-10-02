<h2>News List</h2>
<div class="container" style="min-height:400px;">
    <div style="margin:20px;">
        <a class="btn btn-primary" href="newsAdd" role="button">Добавить новость</a>
    </div>
    <div class="col-md-11">
        <table class="table table-bordered table-responsive">
            <tr>
                <th width="10%">ID</th>
                <th width="70%">Header News</th>
                <th width="20%"></th>
            </tr>
            <?php foreach ($arr as $row): ?>
            <tr>
                <td><?= (int)$row['id'] ?></td>
                <td>
                    <b>Title:</b> <?= htmlspecialchars($row['title']) ?><br>
                    <b>Категория:</b> <i><?= htmlspecialchars($row['name']) ?></i><br>
                    <b>Author:</b> <i><?= htmlspecialchars($row['username']) ?></i>
                </td>
                <td>
                    <a href="newsEdit?id=<?= (int)$row['id'] ?>">Edit <span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
                    <a href="newsDel?id=<?= (int)$row['id'] ?>">Delete <span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>
