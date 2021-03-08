@extends(Auth::check() ? 'layouts.dashboard' : 'layouts.app')

@section('content')
<link href="{{ asset('css/welcome.css') }}" rel="stylesheet">

<div class="container-fluid" style="margin-top: 100px;">
  @verbatim
    <div class="row justify-content-center" ng-init="get_whereabouts()" ng-cloak>
        <div class="col-lg-12 text-center">
            <h1 class="font-weight-bold"> WhereAbouts </h1>
            <p class="font-weight-light"> Staffs Travel/Meeting&Schedules </p>
            <hr class="mb-5" style="width: 50%;">
        </div>

        
        <div class="col-sm-12 col-lg-5">
        	<div class="input-group mb-5">
			  <input type="text" class="form-control" aria-describedby="search_employee" placeholder="Search...">
			  <div class="input-group-append">
			    <button class="btn btn-light" style="border-radius: 50px !important;" type="button"> Search <i class="fa fa-search"></i> </button>
			  </div>
			</div>

        <div class="row h-100 justify-content-center">
          <div class="col-lg-12">
					<div class="media mb-3" style="border-right: solid 4px #007bff;" ng-repeat="emp in whereabouts_data">
						<img class="mr-3" src="/images/for_welcome/team/eng_bernat.jpg" style="object-fit: cover; width: 64px; height: 64px; border-radius: 50px;" alt="Generic placeholder image">
						<div class="media-body">
							<h5 class="mt-0">Top-aligned media</h5>
							<span ng-bind="emp.title"></span> <br>
							<span ng-bind="emp.location"></span>
							<span ng-bind="emp.start_date | date:'mediumDate'"></span> - <span ng-bind="emp.end_date | date:'mediumDate'"></span> <br>
							<small>Donec sed odio dui. Nullam quis risus eget urna mollis ornare vel eu leo. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</small>
						</div>
					</div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-lg-7">
            <div id="calendar"></div>
        </div>
    </div>
  @endverbatim
</div>
<script type="text/javascript" src="{{ asset('/js/underscore.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/pre_req/moment_.js') }}"></script>
<script type="text/javascript">
            // Calendar
            var today = moment();

            function Calendar(selector, events) {
              this.el = document.querySelector(selector);
              this.events = events;
              this.current = moment().date(1);
              this.draw();
              var current = document.querySelector('.today');
              if(current) {
                var self = this;
                window.setTimeout(function() {
                  self.openDay(current);
                }, 500);
              }
            }

            Calendar.prototype.draw = function() {
              //Create Header
              this.drawHeader();

              //Draw Month
              this.drawMonth();

              // this.drawLegend();
            }

            Calendar.prototype.drawHeader = function() {
              var self = this;
              if(!this.header) {
                //Create the header elements
                this.header = createElement('div', 'header');
                this.header.className = 'header';

                this.title = createElement('h1');

                var right = createElement('div', 'right');
                right.addEventListener('click', function() { self.nextMonth(); });

                var left = createElement('div', 'left');
                left.addEventListener('click', function() { self.prevMonth(); });

                //Append the Elements
                this.header.appendChild(this.title); 
                this.header.appendChild(right);
                this.header.appendChild(left);
                this.el.appendChild(this.header);
              }

              this.title.innerHTML = this.current.format('MMMM YYYY');
            }

            Calendar.prototype.drawMonth = function() {
              var self = this;
              
              this.events.forEach(function(ev) {
               ev.date = self.current.clone().date(Math.random() * (29 - 1) + 1);
              });
              
              
              if(this.month) {
                this.oldMonth = this.month;
                this.oldMonth.className = 'month out ' + (self.next ? 'next' : 'prev');
                this.oldMonth.addEventListener('webkitAnimationEnd', function() {
                  self.oldMonth.parentNode.removeChild(self.oldMonth);
                  self.month = createElement('div', 'month');
                  self.backFill();
                  self.currentMonth();
                  self.fowardFill();
                  self.el.appendChild(self.month);
                  window.setTimeout(function() {
                    self.month.className = 'month in ' + (self.next ? 'next' : 'prev');
                  }, 16);
                });
              } else {
                  this.month = createElement('div', 'month');
                  this.el.appendChild(this.month);
                  this.backFill();
                  this.currentMonth();
                  this.fowardFill();
                  this.month.className = 'month new';
              }
            }

            Calendar.prototype.backFill = function() {
              var clone = this.current.clone();
              var dayOfWeek = clone.day();

              if(!dayOfWeek) { return; }

              clone.subtract(dayOfWeek+1, 'days');

              for(var i = dayOfWeek; i > 0 ; i--) {
                this.drawDay(clone.add(1, 'days'));
              }
            }

            Calendar.prototype.fowardFill = function() {
              var clone = this.current.clone().add(1, 'months').subtract(1,'days');
              var dayOfWeek = clone.day();

              if(dayOfWeek === 6) { return; }

              for(var i = dayOfWeek; i < 6 ; i++) {
                this.drawDay(clone.add(1, 'days'));
              }
            }

            Calendar.prototype.currentMonth = function() {
              var clone = this.current.clone();

              while(clone.month() === this.current.month()) {
                this.drawDay(clone);
                clone.add(1, 'days');
              }
            }

            Calendar.prototype.getWeek = function(day) {
              if(!this.week || day.day() === 0) {
                this.week = createElement('div', 'week');
                this.month.appendChild(this.week);
              }
            }

            Calendar.prototype.drawDay = function(day) {
              var self = this;
              this.getWeek(day);

              //Outer Day
              var outer = createElement('div', this.getDayClass(day));
              outer.addEventListener('click', function() {
                self.openDay(this);
              });

              //Day Name
              var name = createElement('div', 'day-name', day.format('ddd'));

              //Day Number
              var number = createElement('div', 'day-number', day.format('DD'));


              //Events
              var events = createElement('div', 'day-events');
              this.drawEvents(day, events);

              outer.appendChild(name);
              outer.appendChild(number);
              outer.appendChild(events);
              this.week.appendChild(outer);
            }

            Calendar.prototype.drawEvents = function(day, element) {
              if(day.month() === this.current.month()) {
                var todaysEvents = this.events.reduce(function(memo, ev) {
                  if(ev.date.isSame(day, 'day')) {
                    memo.push(ev);
                  }
                  return memo;
                }, []);

                todaysEvents.forEach(function(ev) {
                  var evSpan = createElement('span', ev.color);
                  element.appendChild(evSpan);
                });
              }
            }

            Calendar.prototype.getDayClass = function(day) {
              classes = ['day'];
              if(day.month() !== this.current.month()) {
                classes.push('other');
              } else if (today.isSame(day, 'day')) {
                classes.push('today');
              }
              return classes.join(' ');
            }

            Calendar.prototype.openDay = function(el) {
              var details, arrow;
              var dayNumber = +el.querySelectorAll('.day-number')[0].innerText || +el.querySelectorAll('.day-number')[0].textContent;
              var day = this.current.clone().date(dayNumber);

              var currentOpened = document.querySelector('.details');

              //Check to see if there is an open detais box on the current row
              if(currentOpened && currentOpened.parentNode === el.parentNode) {
                details = currentOpened;
                arrow = document.querySelector('.arrow');
              } else {
                //Close the open events on differnt week row
                //currentOpened && currentOpened.parentNode.removeChild(currentOpened);
                if(currentOpened) {
                  currentOpened.addEventListener('webkitAnimationEnd', function() {
                    currentOpened.parentNode.removeChild(currentOpened);
                  });
                  currentOpened.addEventListener('oanimationend', function() {
                    currentOpened.parentNode.removeChild(currentOpened);
                  });
                  currentOpened.addEventListener('msAnimationEnd', function() {
                    currentOpened.parentNode.removeChild(currentOpened);
                  });
                  currentOpened.addEventListener('animationend', function() {
                    currentOpened.parentNode.removeChild(currentOpened);
                  });
                  currentOpened.className = 'details out';
                }

                //Create the Details Container
                details = createElement('div', 'details in');

                //Create the arrow
                var arrow = createElement('div', 'arrow');

                //Create the event wrapper

                details.appendChild(arrow);
                el.parentNode.appendChild(details);
              }

              var todaysEvents = this.events.reduce(function(memo, ev) {
                if(ev.date.isSame(day, 'day')) {
                  memo.push(ev);
                }
                return memo;
              }, []);

              this.renderEvents(todaysEvents, details);

              arrow.style.left = el.offsetLeft - el.parentNode.offsetLeft + 27 + 'px';
            }

            Calendar.prototype.renderEvents = function(events, ele) {
              //Remove any events in the current details element
              var currentWrapper = ele.querySelector('.events');
              var wrapper = createElement('div', 'events in' + (currentWrapper ? ' new' : ''));

              events.forEach(function(ev) {
                var div = createElement('div', 'event');
                var square = createElement('div', 'event-category ' + ev.color);
                var span = createElement('span', '', ev.eventName);

                div.appendChild(square);
                div.appendChild(span);
                wrapper.appendChild(div);
              });

              if(!events.length) {
                var div = createElement('div', 'event empty');
                var span = createElement('span', '', 'No Events');

                div.appendChild(span);
                wrapper.appendChild(div);
              }

              if(currentWrapper) {
                currentWrapper.className = 'events out';
                currentWrapper.addEventListener('webkitAnimationEnd', function() {
                  currentWrapper.parentNode.removeChild(currentWrapper);
                  ele.appendChild(wrapper);
                });
                currentWrapper.addEventListener('oanimationend', function() {
                  currentWrapper.parentNode.removeChild(currentWrapper);
                  ele.appendChild(wrapper);
                });
                currentWrapper.addEventListener('msAnimationEnd', function() {
                  currentWrapper.parentNode.removeChild(currentWrapper);
                  ele.appendChild(wrapper);
                });
                currentWrapper.addEventListener('animationend', function() {
                  currentWrapper.parentNode.removeChild(currentWrapper);
                  ele.appendChild(wrapper);
                });
              } else {
                ele.appendChild(wrapper);
              }
            }

            // Calendar.prototype.drawLegend = function() {
            //   var legend = createElement('div', 'legend');
            //   var calendars = this.events.map(function(e) {
            //     return e.calendar + '|' + e.color;
            //   }).reduce(function(memo, e) {
            //     if(memo.indexOf(e) === -1) {
            //       memo.push(e);
            //     }
            //     return memo;
            //   }, []).forEach(function(e) {
            //     var parts = e.split('|');
            //     var entry = createElement('span', 'entry ' +  parts[1], parts[0]);
            //     legend.appendChild(entry);
            //   });
            //   this.el.appendChild(legend);
            // }

            Calendar.prototype.nextMonth = function() {
              this.current.add(1, 'months');
              this.next = true;
              this.draw();
            }

            Calendar.prototype.prevMonth = function() {
              this.current.subtract(1, 'months');
              this.next = false;
              this.draw();
            }

            window.Calendar = Calendar;

            function createElement(tagName, className, innerText) {
              var ele = document.createElement(tagName);
              if(className) {
                ele.className = className;
              }
              if(innerText) {
                ele.innderText = ele.textContent = innerText;
              }
              return ele;
            }


            var data = [
              // { eventName: 'Lunch Meeting w/ Mark', calendar: 'Work', color: 'orange' },
              // { eventName: 'Interview - Jr. Web Developer', calendar: 'Work', color: 'orange' },
              // { eventName: 'Demo New App to the Board', calendar: 'Work', color: 'orange' },
              // { eventName: 'Dinner w/ Marketing', calendar: 'Work', color: 'orange' },

              // { eventName: 'Game vs Portalnd', calendar: 'Sports', color: 'blue' },
              // { eventName: 'Game vs Houston', calendar: 'Sports', color: 'blue' },
              // { eventName: 'Game vs Denver', calendar: 'Sports', color: 'blue' },
              // { eventName: 'Game vs San Degio', calendar: 'Sports', color: 'blue' },

              // { eventName: 'School Play', calendar: 'Kids', color: 'yellow' },
              // { eventName: 'Parent/Teacher Conference', calendar: 'Kids', color: 'yellow' },
              // { eventName: 'Pick up from Soccer Practice', calendar: 'Kids', color: 'yellow' },
              // { eventName: 'Ice Cream Night', calendar: 'Kids', color: 'yellow' },

              // { eventName: 'Free Tamale Night', calendar: 'Other', color: 'green' },
              // { eventName: 'Bowling Team', calendar: 'Other', color: 'green' },
              // { eventName: 'Teach Kids to Code', calendar: 'Other', color: 'green' },
              // { eventName: 'Startup Weekend', calendar: 'Other', color: 'green' }
            ];

            function addDate(ev) {
              
            }

            var calendar = new Calendar('#calendar', data);
</script>
@endsection