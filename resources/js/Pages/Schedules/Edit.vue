<template>
  <div>
    <div class="flex h-full flex-col">
      <header class="relative  flex flex-none items-center justify-between border-b border-gray-200 py-4">
        <h1 class="text-lg font-semibold text-gray-900">
          <!--        <time datetime="2022-01">January 2022</time>-->
        </h1>
        <select
          @change="bodyOnchange"
          class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-solid border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
          v-model="scheduleData.body.id"
        >
          <option v-for="body in bodies" :value="body.id">{{ body.name }}</option>
        </select>
        <div class="flex items-center">
          <!--        <div class="flex items-center rounded-md shadow-sm md:items-stretch">-->
          <!--          <button type="button" class="flex items-center justify-center rounded-l-md border border-r-0 border-gray-300 bg-white py-2 pl-3 pr-4 text-gray-400 hover:text-gray-500 focus:relative md:w-9 md:px-2 md:hover:bg-gray-50">-->
          <!--            <span class="sr-only">Previous month</span>-->
          <!--            &lt;!&ndash; Heroicon name: solid/chevron-left &ndash;&gt;-->
          <!--            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">-->
          <!--              <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />-->
          <!--            </svg>-->
          <!--          </button>-->
          <!--          <button type="button" class="hidden border-t border-b border-gray-300 bg-white px-3.5 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 focus:relative md:block">Today</button>-->
          <!--          <span class="relative -mx-px h-5 w-px bg-gray-300 md:hidden"></span>-->
          <!--          <button type="button" class="flex items-center justify-center rounded-r-md border border-l-0 border-gray-300 bg-white py-2 pl-4 pr-3 text-gray-400 hover:text-gray-500 focus:relative md:w-9 md:px-2 md:hover:bg-gray-50">-->
          <!--            <span class="sr-only">Next month</span>-->
          <!--            &lt;!&ndash; Heroicon name: solid/chevron-right &ndash;&gt;-->
          <!--            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">-->
          <!--              <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />-->
          <!--            </svg>-->
          <!--          </button>-->
          <!--        </div>-->
          <div class="hidden md:ml-4 md:flex md:items-center">
            <!--          <div class="relative">-->
            <!--            <button type="button" class="flex items-center rounded-md border border-gray-300 bg-white py-2 pl-3 pr-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50" id="menu-button" aria-expanded="false" aria-haspopup="true">-->
            <!--              Week view-->
            <!--              &lt;!&ndash; Heroicon name: solid/chevron-down &ndash;&gt;-->
            <!--              <svg class="ml-2 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">-->
            <!--                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />-->
            <!--              </svg>-->
            <!--            </button>-->

            <!--            &lt;!&ndash;-->
            <!--              Dropdown menu, show/hide based on menu state.-->

            <!--              Entering: "transition ease-out duration-100"-->
            <!--                From: "transform opacity-0 scale-95"-->
            <!--                To: "transform opacity-100 scale-100"-->
            <!--              Leaving: "transition ease-in duration-75"-->
            <!--                From: "transform opacity-100 scale-100"-->
            <!--                To: "transform opacity-0 scale-95"-->
            <!--            &ndash;&gt;-->
            <!--            <div class="absolute right-0 mt-3 w-36 origin-top-right overflow-hidden rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">-->
            <!--              <div class="py-1" role="none">-->
            <!--                &lt;!&ndash; Active: "bg-gray-100 text-gray-900", Not Active: "text-gray-700" &ndash;&gt;-->
            <!--                <a href="#" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-0">Day view</a>-->
            <!--                <a href="#" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-1">Week view</a>-->
            <!--                <a href="#" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-2">Month view</a>-->
            <!--                <a href="#" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-3">Year view</a>-->
            <!--              </div>-->
            <!--            </div>-->
            <!--          </div>-->
            <div class="ml-6 h-6 w-px bg-gray-300"></div>
            <button
              @click="toggleAddWorkoutModal(true)"
              type="button"
              class="ml-6 rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
              Add event
            </button>
          </div>
          <div class="relative ml-6 md:hidden">
            <button type="button"
                    class="-mx-2 flex items-center rounded-full border border-transparent p-2 text-gray-400 hover:text-gray-500"
                    id="menu-0-button" aria-expanded="false" aria-haspopup="true">
              <span class="sr-only">Open menu</span>
              <!-- Heroicon name: solid/dots-horizontal -->
              <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                   aria-hidden="true">
                <path
                  d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"/>
              </svg>
            </button>

            <!--
              Dropdown menu, show/hide based on menu state.

              Entering: "transition ease-out duration-100"
                From: "transform opacity-0 scale-95"
                To: "transform opacity-100 scale-100"
              Leaving: "transition ease-in duration-75"
                From: "transform opacity-100 scale-100"
                To: "transform opacity-0 scale-95"
            -->
            <div
              class="absolute right-0 mt-3 w-36 origin-top-right divide-y divide-gray-100 overflow-hidden rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
              role="menu" aria-orientation="vertical" aria-labelledby="menu-0-button" tabindex="-1">
              <div class="py-1" role="none">
                <!-- Active: "bg-gray-100 text-gray-900", Not Active: "text-gray-700" -->
                <a href="#" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1"
                   id="menu-0-item-0">Create event</a>
              </div>
              <!--            <div class="py-1" role="none">-->
              <!--              <a href="#" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-0-item-1">Go to today</a>-->
              <!--            </div>-->
              <!--            <div class="py-1" role="none">-->
              <!--              <a href="#" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-0-item-2">Day view</a>-->
              <!--              <a href="#" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-0-item-3">Week view</a>-->
              <!--              <a href="#" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-0-item-4">Month view</a>-->
              <!--              <a href="#" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-0-item-5">Year view</a>-->
              <!--            </div>-->
            </div>
          </div>
        </div>
      </header>


      <!-- This example requires Tailwind CSS v2.0+ -->
      <div
        v-if="isEventModalOpen" class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!--
          Background backdrop, show/hide based on modal state.

          Entering: "ease-out duration-300"
            From: "opacity-0"
            To: "opacity-100"
          Leaving: "ease-in duration-200"
            From: "opacity-100"
            To: "opacity-0"
        -->
        <div @click="toggleAddWorkoutModal(false)"
             class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <div class="fixed z-10 inset-0 overflow-y-auto pointer-events-none">
          <div class="flex items-end sm:items-center justify-center min-h-full p-4 text-center sm:p-0">
            <!--
              Modal panel, show/hide based on modal state.

              Entering: "ease-out duration-300"
                From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                To: "opacity-100 translate-y-0 sm:scale-100"
              Leaving: "ease-in duration-200"
                From: "opacity-100 translate-y-0 sm:scale-100"
                To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            -->
            <div
              class="pointer-events-auto	relative z-10 bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full sm:p-6">
              <div>
                <!--                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">-->
                <!--                  &lt;!&ndash; Heroicon name: outline/check &ndash;&gt;-->
                <!--                  <svg class="h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">-->
                <!--                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />-->
                <!--                  </svg>-->
                <!--                </div>-->
                <div class="mt-3 text-center sm:mt-5">
                  <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Add Workout</h3>
                  <div class="mt-2">
                    <!-- This example requires Tailwind CSS v2.0+ -->
                    <div>
                      <div class="mt-1 relative space-y-4">

                        <div>
                          <label for="select-weekday" class="block text-sm font-medium text-gray-700">Day of the
                            week</label>
                          <select
                            ref="select-weekday"
                            id="select-weekday" name="select-weekday"
                            :value="getActiveDay.id"
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-solid border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="1">Monday</option>
                            <option value="2">Tuesday</option>
                            <option value="3">Wednesday</option>
                            <option value="4">Thursday</option>
                            <option value="5">Friday</option>
                            <option value="6">Saturday</option>
                            <option value="7">Sunday</option>

                          </select>
                        </div>

                        <div>
                          <label for="workout" class="block text-sm font-medium text-gray-700">Select workout</label>
                          <select ref="select-workout"
                                  id="workout" name="workout"
                                  class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-solid border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option v-for="workout in workouts" :value="workout.id">{{ workout.name }}</option>

                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                <button
                  @click="submitEvent($refs['select-workout'].value, $refs['select-weekday'].value)"
                  type="button"
                  class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:col-start-2 sm:text-sm">
                  Add Workout
                </button>
                <button
                  @click="toggleAddWorkoutModal"
                  type="button"
                  class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:col-start-1 sm:text-sm">
                  Cancel
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>


      <div class="flex flex-auto flex-col bg-white">
        <div style="width: 165%" class="flex max-w-full flex-none flex-col sm:max-w-none md:max-w-full">
          <div class="sticky top-0 flex-none bg-white shadow ring-1 ring-black ring-opacity-5">
            <div class="grid grid-cols-7 text-sm leading-6 text-gray-500 sm:hidden">
              <button type="button" class="flex flex-col items-center pt-2 pb-3">M <span
                class="mt-1 flex h-8 w-8 items-center justify-center font-semibold text-gray-900">10</span></button>
              <button type="button" class="flex flex-col items-center pt-2 pb-3">T <span
                class="mt-1 flex h-8 w-8 items-center justify-center font-semibold text-gray-900">11</span></button>
              <button type="button" class="flex flex-col items-center pt-2 pb-3">W <span
                class="mt-1 flex h-8 w-8 items-center justify-center rounded-full bg-indigo-600 font-semibold text-white">12</span>
              </button>
              <button type="button" class="flex flex-col items-center pt-2 pb-3">T <span
                class="mt-1 flex h-8 w-8 items-center justify-center font-semibold text-gray-900">13</span></button>
              <button type="button" class="flex flex-col items-center pt-2 pb-3">F <span
                class="mt-1 flex h-8 w-8 items-center justify-center font-semibold text-gray-900">14</span></button>
              <button type="button" class="flex flex-col items-center pt-2 pb-3">S <span
                class="mt-1 flex h-8 w-8 items-center justify-center font-semibold text-gray-900">15</span></button>
              <button type="button" class="flex flex-col items-center pt-2 pb-3">S <span
                class="mt-1 flex h-8 w-8 items-center justify-center font-semibold text-gray-900">16</span></button>
            </div>

            <div
              class="-mr-px hidden grid-cols-7 divide-x divide-gray-100 border-r border-gray-100 text-sm leading-6 text-gray-500 sm:grid">
              <!--            <div class="col-end-1 w-14"></div>-->
              <div v-for="day in sharedState" :key="'title-'+day.id" class="flex items-center justify-center py-3">
                <span>{{ day.abbvTitle }}</span>
              </div>
            </div>
          </div>
          <div class="flex flex-auto">
            <!--          <div class="sticky left-0 z-10 w-14 flex-none bg-white ring-1 ring-gray-100"></div>-->
            <div class="grid flex-auto grid-cols-1 grid-rows-1">
              <!-- Horizontal lines -->
              <!--            <div class="col-start-1 col-end-2 row-start-1 grid divide-y divide-gray-100 grid grid-cols-7">-->
              <!--              <div class="row-end-1 h-7"></div>-->
              <!--              <div>-->
              <!--                <div class="sticky left-0 z-20 -mt-2.5 -ml-14 w-14 pr-2 text-right text-xs leading-5 text-gray-400">12AM</div>-->
              <!--              </div>-->
              <!--              <div></div>-->
              <!--              <div>-->
              <!--                <div class="sticky left-0 z-20 -mt-2.5 -ml-14 w-14 pr-2 text-right text-xs leading-5 text-gray-400">1AM</div>-->
              <!--              </div>-->
              <!--              <div></div>-->
              <!--              <div>-->
              <!--                <div class="sticky left-0 z-20 -mt-2.5 -ml-14 w-14 pr-2 text-right text-xs leading-5 text-gray-400">2AM</div>-->
              <!--              </div>-->
              <!--              <div></div>-->
              <!--              <div>-->
              <!--                <div class="sticky left-0 z-20 -mt-2.5 -ml-14 w-14 pr-2 text-right text-xs leading-5 text-gray-400">3AM</div>-->
              <!--              </div>-->
              <!--              <div></div>-->
              <!--              <div>-->
              <!--                <div class="sticky left-0 z-20 -mt-2.5 -ml-14 w-14 pr-2 text-right text-xs leading-5 text-gray-400">4AM</div>-->
              <!--              </div>-->
              <!--              <div></div>-->
              <!--              <div>-->
              <!--                <div class="sticky left-0 z-20 -mt-2.5 -ml-14 w-14 pr-2 text-right text-xs leading-5 text-gray-400">5AM</div>-->
              <!--              </div>-->
              <!--              <div></div>-->
              <!--              <div>-->
              <!--                <div class="sticky left-0 z-20 -mt-2.5 -ml-14 w-14 pr-2 text-right text-xs leading-5 text-gray-400">6AM</div>-->
              <!--              </div>-->
              <!--              <div></div>-->
              <!--              <div>-->
              <!--                <div class="sticky left-0 z-20 -mt-2.5 -ml-14 w-14 pr-2 text-right text-xs leading-5 text-gray-400">7AM</div>-->
              <!--              </div>-->
              <!--              <div></div>-->
              <!--              <div>-->
              <!--                <div class="sticky left-0 z-20 -mt-2.5 -ml-14 w-14 pr-2 text-right text-xs leading-5 text-gray-400">8AM</div>-->
              <!--              </div>-->
              <!--              <div></div>-->
              <!--              <div>-->
              <!--                <div class="sticky left-0 z-20 -mt-2.5 -ml-14 w-14 pr-2 text-right text-xs leading-5 text-gray-400">9AM</div>-->
              <!--              </div>-->
              <!--              <div></div>-->
              <!--              <div>-->
              <!--                <div class="sticky left-0 z-20 -mt-2.5 -ml-14 w-14 pr-2 text-right text-xs leading-5 text-gray-400">10AM</div>-->
              <!--              </div>-->
              <!--              <div></div>-->
              <!--              <div>-->
              <!--                <div class="sticky left-0 z-20 -mt-2.5 -ml-14 w-14 pr-2 text-right text-xs leading-5 text-gray-400">11AM</div>-->
              <!--              </div>-->
              <!--              <div></div>-->
              <!--              <div>-->
              <!--                <div class="sticky left-0 z-20 -mt-2.5 -ml-14 w-14 pr-2 text-right text-xs leading-5 text-gray-400">12PM</div>-->
              <!--              </div>-->
              <!--              <div></div>-->
              <!--              <div>-->
              <!--                <div class="sticky left-0 z-20 -mt-2.5 -ml-14 w-14 pr-2 text-right text-xs leading-5 text-gray-400">1PM</div>-->
              <!--              </div>-->
              <!--              <div></div>-->
              <!--              <div>-->
              <!--                <div class="sticky left-0 z-20 -mt-2.5 -ml-14 w-14 pr-2 text-right text-xs leading-5 text-gray-400">2PM</div>-->
              <!--              </div>-->
              <!--              <div></div>-->
              <!--              <div>-->
              <!--                <div class="sticky left-0 z-20 -mt-2.5 -ml-14 w-14 pr-2 text-right text-xs leading-5 text-gray-400">3PM</div>-->
              <!--              </div>-->
              <!--              <div></div>-->
              <!--              <div>-->
              <!--                <div class="sticky left-0 z-20 -mt-2.5 -ml-14 w-14 pr-2 text-right text-xs leading-5 text-gray-400">4PM</div>-->
              <!--              </div>-->
              <!--              <div></div>-->
              <!--              <div>-->
              <!--                <div class="sticky left-0 z-20 -mt-2.5 -ml-14 w-14 pr-2 text-right text-xs leading-5 text-gray-400">5PM</div>-->
              <!--              </div>-->
              <!--              <div></div>-->
              <!--              <div>-->
              <!--                <div class="sticky left-0 z-20 -mt-2.5 -ml-14 w-14 pr-2 text-right text-xs leading-5 text-gray-400">6PM</div>-->
              <!--              </div>-->
              <!--              <div></div>-->
              <!--              <div>-->
              <!--                <div class="sticky left-0 z-20 -mt-2.5 -ml-14 w-14 pr-2 text-right text-xs leading-5 text-gray-400">7PM</div>-->
              <!--              </div>-->
              <!--              <div></div>-->
              <!--              <div>-->
              <!--                <div class="sticky left-0 z-20 -mt-2.5 -ml-14 w-14 pr-2 text-right text-xs leading-5 text-gray-400">8PM</div>-->
              <!--              </div>-->
              <!--              <div></div>-->
              <!--              <div>-->
              <!--                <div class="sticky left-0 z-20 -mt-2.5 -ml-14 w-14 pr-2 text-right text-xs leading-5 text-gray-400">9PM</div>-->
              <!--              </div>-->
              <!--              <div></div>-->
              <!--              <div>-->
              <!--                <div class="sticky left-0 z-20 -mt-2.5 -ml-14 w-14 pr-2 text-right text-xs leading-5 text-gray-400">10PM</div>-->
              <!--              </div>-->
              <!--              <div></div>-->
              <!--              <div>-->
              <!--                <div class="sticky left-0 z-20 -mt-2.5 -ml-14 w-14 pr-2 text-right text-xs leading-5 text-gray-400">11PM</div>-->
              <!--              </div>-->
              <!--              <div></div>-->
              <!--            </div>-->

              <!-- Vertical lines -->
              <div class="hidden grid-cols-7 divide-x divide-gray-100 sm:grid sm:grid-cols-7 h-60">
                <div
                  v-for="day in sharedState" :key="'weekday-'+day.id"
                  @click.self="
                  setActiveDay(day.id);
                  toggleAddWorkoutModal(true)
                  "
                  class="row-span-full space-y-4 p-2">

                  <div>
                    Calorie Intake:
                    <input
                      @change="updateSchedule"
                      v-model="day.calorieIntake"
                      type="number" />
                  </div>



                  <div v-for="(workout, index) in day.events" :key="index"
                       class="bg-gray-100 w-full rounded py-3 text-center justify-between flex space-x-3 items-center px-3">
                    <div>{{ workout.details }}</div>
                    <div @click="destroyEvent(workout, day.id)" class="cursor-pointer">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                           stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                      </svg>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Events -->
              <!--            <ol class="col-start-1 col-end-2 row-start-1 grid grid-cols-1 sm:grid-cols-7 sm:pr-8" style="grid-template-rows: 1.75rem repeat(288, minmax(0, 1fr)) auto">-->
              <!--              <li class="relative mt-px flex sm:col-start-3" style="grid-row: 1 / span 12">-->
              <!--                <a href="#" class="group absolute inset-1 flex flex-col overflow-y-auto rounded-lg bg-blue-50 p-2 text-xs leading-5 hover:bg-blue-100">-->
              <!--                  <p class="order-1 font-semibold text-blue-700">Breakfast</p>-->
              <!--                  <p class="text-blue-500 group-hover:text-blue-700"><time datetime="2022-01-12T06:00">6:00 AM</time></p>-->
              <!--                </a>-->
              <!--              </li>-->
              <!--              <li class="relative mt-px flex sm:col-start-3" style="grid-row: 4 / span 30">-->
              <!--                <a href="#" class="group absolute inset-1 flex flex-col overflow-y-auto rounded-lg bg-pink-50 p-2 text-xs leading-5 hover:bg-pink-100">-->
              <!--                  <p class="order-1 font-semibold text-pink-700">Flight to Paris</p>-->
              <!--                  <p class="text-pink-500 group-hover:text-pink-700"><time datetime="2022-01-12T07:30">7:30 AM</time></p>-->
              <!--                </a>-->
              <!--              </li>-->
              <!--              <li class="relative mt-px hidden sm:col-start-6 sm:flex" style="grid-row: 1 / span 24">-->
              <!--                <a href="#" class="group absolute inset-1 flex flex-col overflow-y-auto rounded-lg bg-gray-100 p-2 text-xs leading-5 hover:bg-gray-200">-->
              <!--                  <p class="order-1 font-semibold text-gray-700">Meeting with design team at Disney</p>-->
              <!--                  <p class="text-gray-500 group-hover:text-gray-700"><time datetime="2022-01-15T10:00">10:00 AM</time></p>-->
              <!--                </a>-->
              <!--              </li>-->
              <!--            </ol>-->
            </div>
          </div>
        </div>
      </div>


      <div class="my-10">
        <div>Period: <input type="number" value="1" min="1"/> weeks</div>
        <div>Daily Calorie Intake: <input @change="updateSchedule" v-model="scheduleData.dailyCalorieIntake" type="number">
        </div>
        <a :href="'/bodydiff/' + schedule.id" class="inline-block rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"> calculate body difference</a>
      </div>
    </div>
  </div>
</template>

<script>

import Layout from '@/Shared/Layout'
import SelectInput from '@/Shared/SelectInput'

import axios from 'axios';

export default {
  components: {
    SelectInput
  },
  props: ['workouts', 'workoutEvents', 'bodies', 'schedule'],
  layout: Layout,
  data() {
    return {
      scheduleData: this.schedule,
      isEventModalOpen: false,
      isSelectDropdownOpen: false,
      sharedState: [
        {
          id: 1,
          abbvTitle: 'Mon',
          fullTitle: 'Monday',
          events: [],
          active: true,
          calorieIntake: 1,
        },
        {
          id: 2,
          abbvTitle: 'Tue',
          fullTitle: 'Tuesday',
          events: [],
          active: false,
          calorieIntake: 3,
        },
        {
          id: 3,
          abbvTitle: 'Wed',
          fullTitle: 'Wednesday',
          events: [],
          active: false,
          calorieIntake: 4,
        },
        {
          id: 4,
          abbvTitle: 'Thu',
          fullTitle: 'Thursday',
          events: [],
          active: false,
          calorieIntake: 5,
        },
        {
          id: 5,
          abbvTitle: 'Fri',
          fullTitle: 'Friday',
          events: [],
          active: false,
          calorieIntake: 6,
        },
        {
          id: 6,
          abbvTitle: 'Sat',
          fullTitle: 'Saturday',
          events: [],
          active: false,
          calorieIntake: 7,
        },
        {
          id: 7,
          abbvTitle: 'Sun',
          fullTitle: 'Sunday',
          events: [],
          active: false,
          calorieIntake: 8,
        }
      ]
    }
  },
  mounted() {
    this.workoutEvents.forEach(workoutEvent => {
      this.sharedState[workoutEvent.day_id - 1].events.push({
        details: workoutEvent.name,
        edit: false,
        id: workoutEvent.id,
      });
    });

    this.sharedState.map((day, index) => {
      day.calorieIntake = this.schedule.calorieIntake[index];
    });
  },
  methods: {
    toggleSelectWorkoutDropdown(e, isopen) {
      if (isopen) {
        this.isSelectDropdownOpen = isopen
        return;
      }
      this.isSelectDropdownOpen = !this.isSelectDropdownOpen;
    },
    toggleAddWorkoutModal(e, isopen) {
      if (isopen) {
        this.isEventModalOpen = isopen;
        return;
      }
      this.isEventModalOpen = !this.isEventModalOpen;
    },
    setActiveDay(dayId) {
      this.sharedState.map((dayObj) => {
        dayObj.id === dayId ? (dayObj.active = true) : (dayObj.active = false);
      });
    },
    submitEvent(eventDetails, dayId) {
      const data = {
        user_workout_id: eventDetails,
        day_id: dayId,
        schedule_id: this.schedule.id
      }

      axios.post('/workout-events', data, {
        headers: {
          'Content-Type': 'application/json',
        },
      })
        .then(res => {
          this.toggleAddWorkoutModal(false);
          const activeDay = this.sharedState[dayId - 1];

          let workoutName = this.workouts.find((workout) => workout.id == eventDetails).name;
          activeDay.events.push({
            details: workoutName,
            edit: false,
            id: res.data.id,
          });

        });
    },
    destroyEvent(workout, dayId) {
      axios.delete('/workout-events/' + workout.id, workout, {
        headers: {
          'Content-Type': 'application/json',
        },
      })
        .then(res => {
          const activeDay = this.sharedState[dayId - 1];
          let eventIndex = activeDay.events.findIndex((element) => element.id == workout.id);

          activeDay.events.splice(eventIndex);
        });
    },
    bodyOnchange() {
      this.updateSchedule();
    },
    updateSchedule() {
      const data = {
        body_id: this.schedule.body.id,
        daily_calorie_intake: this.schedule.dailyCalorieIntake,
        mon_calorie_intake: this.sharedState[0].calorieIntake,
        tue_calorie_intake: this.sharedState[1].calorieIntake,
        wed_calorie_intake: this.sharedState[2].calorieIntake,
        thu_calorie_intake: this.sharedState[3].calorieIntake,
        fri_calorie_intake: this.sharedState[4].calorieIntake,
        sat_calorie_intake: this.sharedState[5].calorieIntake,
        sun_calorie_intake: this.sharedState[6].calorieIntake,
      }

      axios.put('/schedules/' + this.schedule.id, data, {
        headers: {
          'Content-Type': 'application/json',
        },
      })
        .then(res => {


        });
    },
    editEvent(dayId, eventDetails) {
      this.resetEditOfAllEvent();
      const eventObj = this.getEventObj(dayId, eventDetails);
      eventObj.edit = true;
    },
    resetEditOfAllEvent() {
      this.sharedState.map((dayObj) => {
        dayObj.events.map((event) => {
          event.edit = false;
        });
      });
    },
    updateEvent(dayId, originalEventDetails, newEventDetails) {
      const eventObj = this.getEventObj(dayId, originalEventDetails);
      eventObj.details = newEventDetails;
      eventObj.edit = false;
    },
    getEventObj(dayId, eventDetails) {
      const dayObj = this.sharedState.find((day) => day.id === dayId);
      return dayObj.events.find((event) => event.details === eventDetails);
    },
    deleteEvent(dayId, eventDetails) {
      const dayObj = this.sharedState.find((day) => dayId === day.id);
      const eventIndexToRemove = dayObj.events.findIndex(
        (event) => event.details === eventDetails
      );
      dayObj.events.splice(eventIndexToRemove, 1);
    },
  },
  computed: {
    getActiveDay() {
      return this.sharedState.find((day) => day.active);
    }
  }
}
</script>

<style scoped>

</style>
