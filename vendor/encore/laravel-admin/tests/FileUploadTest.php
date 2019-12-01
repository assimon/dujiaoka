<?php

use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Support\Facades\File;
use Tests\Models\File as FileModel;

class FileUploadTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->be(Administrator::first(), 'admin');
    }

    public function testFileUploadPage()
    {
        $this->visit('admin/files/create')
            ->see('Upload file')
            ->seeInElement('h3[class=box-title]', 'Create')
            ->seeElement('input[name=file1]')
            ->seeElement('input[name=file2]')
            ->seeElement('input[name=file3]')
            ->seeElement('input[name=file4]')
            ->seeElement('input[name=file5]')
            ->seeElement('input[name=file6]')
//            ->seeInElement('a[href="/admin/files"]', 'List')
            ->seeInElement('button[type=reset]', 'Reset')
            ->seeInElement('button[type=submit]', 'Submit');
    }

    protected function uploadFiles()
    {
        return $this->visit('admin/files/create')
            ->attach(__DIR__.'/AuthTest.php', 'file1')
            ->attach(__DIR__.'/InstallTest.php', 'file2')
            ->attach(__DIR__.'/IndexTest.php', 'file3')
            ->attach(__DIR__.'/LaravelTest.php', 'file4')
            ->attach(__DIR__.'/routes.php', 'file5')
            ->attach(__DIR__.'/migrations/2016_11_22_093148_create_test_tables.php', 'file6')
            ->press('Submit');
    }

    public function testUploadFile()
    {
        File::cleanDirectory(public_path('uploads/files'));

        $this->uploadFiles()
            ->seePageIs('admin/files');

        $this->assertEquals(FileModel::count(), 1);

        $where = [
            'file1' => 'files/AuthTest.php',
            'file2' => 'files/InstallTest.php',
            'file3' => 'files/IndexTest.php',
            'file4' => 'files/LaravelTest.php',
            'file5' => 'files/routes.php',
            'file6' => 'files/2016_11_22_093148_create_test_tables.php',
        ];

        $this->seeInDatabase('test_files', $where);

        $files = FileModel::first()->toArray();

        foreach (range(1, 6) as $index) {
            $this->assertFileExists(public_path('uploads/'.$files['file'.$index]));
        }

        File::cleanDirectory(public_path('uploads/files'));
    }

    public function testUpdateFile()
    {
        File::cleanDirectory(public_path('uploads/files'));

        $this->uploadFiles();

        $old = FileModel::first();

        $this->visit('admin/files/1/edit')
            ->see('ID')
            ->see('Created At')
            ->see('Updated At')
            ->seeElement('input[name=file1]')
            ->seeElement('input[name=file2]')
            ->seeElement('input[name=file3]')
            ->seeElement('input[name=file4]')
            ->seeElement('input[name=file5]')
            ->seeElement('input[name=file6]')
//            ->seeInElement('a[href="/admin/files"]', 'List')
            ->seeInElement('button[type=reset]', 'Reset')
            ->seeInElement('button[type=submit]', 'Submit');

        $this->attach(__DIR__.'/RolesTest.php', 'file3')
            ->attach(__DIR__.'/MenuTest.php', 'file4')
            ->attach(__DIR__.'/TestCase.php', 'file5')
            ->press('Submit');

        $new = FileModel::first();

        $this->assertEquals($old->id, $new->id);
        $this->assertEquals($old->file1, $new->file1);
        $this->assertEquals($old->file2, $new->file2);
        $this->assertEquals($old->file6, $new->file6);

        $this->assertNotEquals($old->file3, $new->file3);
        $this->assertNotEquals($old->file4, $new->file4);
        $this->assertNotEquals($old->file5, $new->file5);

        File::cleanDirectory(public_path('uploads/files'));
    }

    public function testDeleteFiles()
    {
        File::cleanDirectory(public_path('uploads/files'));

        $this->uploadFiles();

        $this->visit('admin/files')
            ->seeInElement('td', 1);

        $files = FileModel::first()->toArray();

        $this->delete('admin/files/1')
            ->dontSeeInDatabase('test_files', ['id' => 1]);

        foreach (range(1, 6) as $index) {
            $this->assertFileNotExists(public_path('uploads/'.$files['file'.$index]));
        }

        $this->visit('admin/files')
            ->seeInElement('td', 'svg');
    }

    public function testBatchDelete()
    {
        File::cleanDirectory(public_path('uploads/files'));

        $this->uploadFiles();
        $this->uploadFiles();
        $this->uploadFiles();

        $this->visit('admin/files')
            ->seeInElement('td', 1)
            ->seeInElement('td', 2)
            ->seeInElement('td', 3);

        $fi = new FilesystemIterator(public_path('uploads/files'), FilesystemIterator::SKIP_DOTS);

        $this->assertEquals(iterator_count($fi), 18);

        $this->assertEquals(FileModel::count(), 3);

        $this->delete('admin/files/1,2,3');

        $this->assertEquals(FileModel::count(), 0);

        $this->visit('admin/files')
            ->seeInElement('td', 'svg');

        $this->assertEquals(iterator_count($fi), 0);
    }
}
