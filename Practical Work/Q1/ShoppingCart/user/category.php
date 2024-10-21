<?php
$categories = $conn->query("SELECT * FROM categories");
?>

<h2>Categories</h2>
<ul>
    <?php while ($cat = $categories->fetch_assoc()) : ?>
        <li><a href="index.php?page=product&category_id=<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></a></li>
    <?php endwhile; ?>
</ul>

<script>
function loadProducts(categoryId, page = 1) {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'user/product.php?category_id=' + categoryId + '&page=' + page, true);
    xhr.onload = function() {
        if (this.status === 200) {
            document.getElementById('products').innerHTML = this.responseText;
        }
    }
    xhr.send();
}

document.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        const categoryId = this.href.split('category_id=')[1];
        loadProducts(categoryId);
    });
});
</script>
