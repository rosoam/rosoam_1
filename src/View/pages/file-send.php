<?php
/**
 * Created by PhpStorm.
 * User: romar
 * Date: 05.05.2018
 * Time: 12:11
 */

$title = "Test send-file";

ob_start();
?>
    <div class="send-file-section section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1>SEND FILE</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <form id="file-send">
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <input type="file" id="file" class="form-control" name="file" required>
                                    <label for="file">Username</label>
                                </div>
                                <div class="col">
                                    <label for="submit">Send file</label>
                                    <input type="submit" id="submit" class="form-control" name="submit" value="Send file" required>
                                </div>
                            </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
<?php
$content = ob_get_clean();
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/template/template-page.php';