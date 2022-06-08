<?php

include __DIR__ . '/bootstrap.php';

init_database();

//snippet iteration-1
$link = mysqli_connect('127.0.0.1', 'user', 'pass');

if (!$link) {
    die('Could not connect: ' . mysqli_error($link));
}

mysqli_set_charset($link, 'utf8');
mysqli_select_db($link, 'db');

$error = null;
if ($_POST && is_valid($_POST['post'])) {
    $post = extract_post($_POST['post']);
    mysqli_query($link, 'START TRANSACTION');
    $sql = sprintf(
        "INSERT INTO posts (title, content) VALUES ('%s', '%s')",
        mysqli_real_escape_string($link, $post['title']),
        mysqli_real_escape_string($link, $post['content'])
    );
    $result = mysqli_query($link, $sql);

    if ($result) {
        mysqli_query($link, 'COMMIT');
    } else {
        mysqli_query($link, 'ROLLBACK');
        $error = 'Post could not be created' . mysqli_error($link);
    }
}

$result = mysqli_query($link,'SELECT id, title, content FROM posts');
?>
<?php include __DIR__ . '/header.php'; ?>
<?php if ($_POST): ?>
    <?php if ($error !== null): ?>
    <div class="alert error"><?php echo $error; ?></div>
    <?php else: ?>
    <div class="alert success">Post was created successfully!</div>
    <?php endif; ?>
<?php endif; ?>
<table>
    <thead><tr><th>ID</th><th>TITLE</th><th>ACTIONS</th></tr></thead>
    <tbody>
    <?php while ($post = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo $post['id']; ?></td>
            <td><?php echo $post['title']; ?></td>
            <td>
                <a href="<?php edit_post_url($post['id']); ?>">Edit</a>
            </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>
<form action="/" method="POST">
    <input type="text" name="post[title]"/>
    <textarea name="post[content]"></textarea>
    <button type="submit">Create post</button>
</form>
<?php include __DIR__ . '/footer.php'; ?>
<?php mysqli_close($link); ?>
<!--end-snippet-->

<?php clear_database() ?>