function update()
{
    if (document.getElementById('book_code').checked)
    {
        document.getElementsByName('search_query')[0].placeholder='Enter Book Code';
    }
    else if (document.getElementById('title').checked)
    {
        document.getElementsByName('search_query')[0].placeholder='Enter Book Title';
    }
    else if (document.getElementById('author').checked)
    {
        document.getElementsByName('search_query')[0].placeholder='Enter Book Author';
    }
    else if (document.getElementById('isbn').checked)
    {
        document.getElementsByName('search_query')[0].placeholder='Enter Book ISBN';
    }
    else if (document.getElementById('publisher').checked)
    {
        document.getElementsByName('search_query')[0].placeholder='Enter Book Publisher';
    }
    else
    {
        document.getElementsByName('search_query')[0].placeholder='Please Select A Search Type';
    }
}