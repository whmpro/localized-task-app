<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tasks Application</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    
</head>
<body>
    <div class="container">
        <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
          <a href="/" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
            <strong>The Task App</strong> 
          </a>
    
          <div class="col-12 col-md-auto mb-2 justify-content-center mb-md-0">
              Your timezone is: <span  >{{$u_timezone}}</span>
          </div>
          <div class="col-md-3 text-end">
            <button type="button" class="btn btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#exampleModal">Create new Task</button> 
          </div>
        </header>
        <div class="row">
            <div class="col-md-12">
                <div class="list-group">
                    @foreach($tasks as $task)
                    <label class="list-group-item d-flex gap-3">
                      <input class="form-check-input flex-shrink-0" type="checkbox" value="" checked="" style="font-size: 1.375em;">
                      <span class="pt-1 form-checked-content">
                        <strong>{{$task->title}}</strong>
                        <small class="d-block text-muted">
                          Deadline:
                          {{$task->deadline->setTimezone($u_timezone)->format('d-M-Y H:i A')}}
                        </small>
                      </span>
                    </label>
                    @endforeach
                    
                     
                  </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        {{-- <form action="{{route('tasks.store')}}" method="POST"> --}}
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Create New Task</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          
              @csrf
              <div class="mb-3">
                  <label for="">Task Title</label>
                  <input type="text" class="form-control" required name="title" id="title">
              </div>
              <div class="mb-3">
                  <label for="">Task Deadline Time</label>
                  <div class="input-group">
                    <input type="time" class="form-control" aria-describedby="button-addon2" name="time" required id="time">
                    <button class="btn btn-outline-secondary" type="button" id="button-addon2">Button</button>
                  </div>
                   
              </div>
              <div class="mb-3">
                <label for="">Task Deadline Date</label>
                <div class="input-group">
                    <input type="date" class="form-control" aria-describedby="button-addon3" name="date" required id="date">
                    <button class="btn btn-outline-secondary" type="button" id="button-addon3">Button</button>
                </div>
            </div>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="subform">Save Task</button>
        </div>
      </div>
    {{-- </form> --}}
    </div>
  </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script type="text/javascript" src="{{asset('js/jquery-3.6.0.min.js')}}"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.14/moment-timezone-with-data-2012-2022.min.js"></script>

    <script>
        $(document).ready(function(){
            var currentTz = moment.tz.guess();
            $("#myTimezone").text(currentTz);
            //var newYork    = moment.tz("2014-06-01 12:00",currentTz);
            //console.log(newYork.format());

            $("#subform").on('click', function(){
                var title = $("#title").val();
                var time = $("#time").val();
                var date = $("#date").val();
                if(title == ""){
                    alert('Please enter title');
                    return false;
                }
                if(time == ""){
                    alert('Please enter time');
                    return false;
                }
                if(date == ""){
                    alert('Please enter date');
                    return false;
                }

                var currentTimeDate = moment.tz(date + ' '+ time, "{{$u_timezone}}");

                //console.log(currentTimeDate.format());

                $.ajax({
                    url: "{{route('tasks.store')}}",
                    type: "POST",
                    data: {
                        title: title,
                        deadline: currentTimeDate.format(),
                        _token: "{{csrf_token()}}"
                    },
                    success: function(data){
                        console.log(data);
                        //$("#exampleModal").modal('hide');
                        //location.reload();
                    }
                });

                

            });

        });
    </script>
     
</body>
</html>