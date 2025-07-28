@extends('layout.user')

@section('content')
<div class="container py-5">
    <h1>File Upload Test</h1>
    
    <form id="testForm" action="{{ route('test.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <input type="file" name="testfile" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Test Upload</button>
    </form>

    <div id="results" class="mt-4 p-3 bg-light rounded" style="display:none;">
        <h4>Results:</h4>
        <pre id="resultData"></pre>
    </div>
</div>

<script>
    document.getElementById('testForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const results = document.getElementById('results');
        const resultData = document.getElementById('resultData');
        
        try {
            const response = await fetch(this.action, {
                method: 'POST',
                body: formData
            });
            
            const data = await response.json();
            resultData.textContent = JSON.stringify(data, null, 2);
            results.style.display = 'block';
            
        } catch (error) {
            resultData.textContent = 'Error: ' + error.message;
            results.style.display = 'block';
        }
    });
</script>
@endsection