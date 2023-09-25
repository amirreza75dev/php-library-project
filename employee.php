<?php
$title = 'employee page';
require_once './header.php';

$isEmployeeLoggedIn = isEmployeeLoggedIn();

if (!$isEmployeeLoggedIn) {
    header('Location: index.php?referrer=employee');
    exit();
} else {
    $sectionNames = getSectionNames();
    $authors = getAuthors();

    echo '<button id="log-out-btn">Log Out</button>';
}
?>

<div class="main">
    <div class="requests">
        <table id="pending-requests">
        </table>
        <button id="approve-requests">Approve Requests</button>
    </div>
    <form class="add-books">
        <div> Adding new book</div>
        <label for="book-name">book name
            <input id="book-name" type="text">
        </label>
        <label for="section-id">section name </br>
            <select name="section" id="section-name">
                <?php
                $html = "";
                foreach ($sectionNames as $section) {
                    $html .= "<option value='" . $section["section_id"] . "'>" . $section['section_name'] . "</option>";
                }
                echo $html;
                ?>
            </select>
        </label>
        <label for="author-id">author
            <select name="author" id="author-name">
                <?php
                $html = "";

                foreach ($authors as $author) {
                    $html .= "<option value='" . $author["author_id"] . "'>" . $author['author_name'] . "</option>";
                }
                echo $html;
                ?>
            </select>

        </label>
        <label for="avl">available
            <input id="avl" type="number">
        </label>
        <button id="submit-book">ADD Book</button>
    </form>
    <!-- searching clients by thier name or email and showing their books -->
    <form class="search-client">
        <div> Searching clients by name</div>
        <label for="search-client-label">Search</label>
        <input id="search-client-input" type="text" placeholder="type name or email of client">
        <button id="submit-search-client">Search</button>
        <div class="client-search-results"></div>
    </form>
    <div class="client-books">
        <table id="client-books-table">
        </table>
    </div>
    <div id="received-book-by-employee">
        <input id="received-book-input" type="text" placeholder="enter the request id">
        <button id="received-btn">receive book</button>
    </div>
    <div class="file-input">
        <p>import file</p>
        <input id="file-input" type ="file" name="books-file" accept=".csv">
        <button id="submit-file">submit file</button>
    </div>
            </br>
            </br>
    <div class="lending-time">
        <div class="">books that will be returned in a specific time</div>
        <input class="lending-time-date" type="date" min='<?php echo date('Y-m-d '); ?>'>
        <table class="lending-time-table">
                    <tr>
                      <th>book name</th>
                      <th>client name</th>
                      <th>client profile and books</th>
                    </tr>

        </table>
    </div>
</div>
<?php include './footer.php' ?>
<script>
readRequests();
clientProfile();
</script>