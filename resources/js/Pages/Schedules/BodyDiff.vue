<template>
  <div>
    <swipe-modal
      :animated="true"
      v-model="modal"
      contents-height="100%"
      border-top-radius="16px"
    >
      <div class="px-4">
        <div class="flex justify-between flex-items mb-5 rounded bg-gray-50 rounded-md px-2 py-2">
          <div class="flex space-x-1 text-lg items-baseline">
            <span class="text-3xl font-bold text-gray-80">{{ scheduleData.weeks }}</span> <span>Weeks</span>
          </div>

          <div class="space-x-2">
            <button
              @mousedown="scheduleData.weeks -= 1; updateSchedule();"
              type="button"
              class="bg-indigo-600 inline-flex justify-center rounded-md border border-transparent p-2 text-lg font-medium text-white">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                   stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4"/>
              </svg>
            </button>
            <button
              @mousedown="scheduleData.weeks += 1; updateSchedule();"
              type="button"
              class="bg-indigo-600 inline-flex justify-center rounded-md border border-transparent p-2 text-lg font-medium text-white">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                   stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
              </svg>
            </button>
          </div>
        </div>
        <div class='flex justify-between mx-auto '>

          <div v-for="day in sharedState" :key="'weekday-'+day.id"
               @click="setActiveDay(day.id)"
               class='flex flex-1 space-x-2 group hover:bg-purple-500 hover:shadow-lg hover-dark-shadow rounded-full mx-1 transition-all	duration-300	 cursor-pointer justify-center '
               :class="[day.active ? 'bg-indigo-600 shadow-lg dark-shadow text-gray-100 ' : 'text-gray-900']">
            <div class='flex items-center py-3'>
              <div class='text-center'>
                <p
                  class='group-hover:text-gray-100 text-sm transition-all  group-hover:font-semibold duration-300'>
                  {{ day.abbvTitle }} </p>
                <p
                  :class="[day.active ? 'text-white ' : 'text-gray-600']"
                  class='font-bold text-xs group-hover:text-gray-100 mt-3 group-hover:font-bold transition-all duration-300'>
                  2kg
                </p>
              </div>
            </div>
          </div>
          <!--          <div-->
          <!--            class='flex group bg-purple-600 shadow-lg dark-shadow rounded-full mx-1 cursor-pointer justify-center relative  '>-->
          <!--            <span class="flex h-2 w-2 absolute bottom-1.5 ">-->
          <!--              <span-->
          <!--                class="animate-ping absolute group-hover:opacity-75 opacity-0 inline-flex h-full w-full rounded-full bg-purple-400 "></span>-->
          <!--              <span class="relative inline-flex rounded-full h- w-3 bg-purple-100"></span>-->
          <!--            </span>-->
          <!--            <div class='flex items-center px-2 my-2 py-2'>-->
          <!--              <div class='text-center'>-->
          <!--                <p class='text-gray-100 text-sm font-semibold'> Wed </p>-->
          <!--                <p class='text-gray-100  mt-3 font-bold'> 14 </p>-->
          <!--              </div>-->
          <!--            </div>-->
          <!--          </div>-->
        </div>


        <div class="bg-indigo-600 rounded-lg space-x-1 p-3 flex items-center text-white mt-8 shadow-xl">
          <div>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd"
                    d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z"
                    clip-rule="evenodd"/>
            </svg>
          </div>
          <div class="flex space-x-2 items-baseline">
            <div class="font-bold text-2xl">{{ formatNumber(0) }}</div>
            <div class="text-sm text-gray-200">kcal</div>
          </div>
        </div>


        <div class="mt-8 flex justify-between">
          <h2 class="text-3xl font-bold text-gray-800">
            {{ activeDay.fullTitle }}
          </h2>

          <!--          <div class="space-x-1 flex items-center text-gray-700">-->
          <!--            <div class="flex space-x-1 items-baseline">-->
          <!--              <div class="font-bold text-xl">{{ formatNumber(activeDayCaloriesBurnt) }}</div>-->
          <!--              <div class="text-sm text-gray-400">kcal</div>-->
          <!--            </div>-->
          <!--          </div>-->
        </div>


        <div class="mt-4 ">


          <div class="rounded-md bg-gray-100 p-3 border-l-4 border-gray-300 ">

            <!--            <div>-->
            <!--              <div class="flex">-->
            <!--                <div>-->
            <!--                  <svg xmlns="http://www.w3.org/2000/svg" class="text-indigo-600 h-8 w-8" fill="none" viewBox="0 0 24 24"-->
            <!--                       stroke="currentColor" stroke-width="2">-->
            <!--                    <path stroke-linecap="round" stroke-linejoin="round"-->
            <!--                          d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>-->
            <!--                  </svg>-->
            <!--                </div>-->
            <!--                <div>-->
            <!--                  <div class="font-bold text-gray-800 text-xl">-->
            <!--                    1700-->
            <!--                  </div>-->
            <!--                </div>-->
            <!--              </div>-->
            <!--            </div>-->

<!--            <svg  class="h-6 w-6" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1000 1000" enable-background="new 0 0 1000 1000" xml:space="preserve">-->
<!--<metadata> Svg Vector Icons : http://www.onlinewebfonts.com/icon </metadata>-->
<!--              <g><path d="M984.4,220.3c-8.4-13.9-22-23.7-39.1-29c-9.2-2.9-22.2-3-30.8,0.4c-4.9,2-8.6,4.8-12.4,7.8c-2,2.1-4,4.1-6,6.1c-4.3,4.1-8.5,8.2-12.7,12.4c-44.4,43.7-88.9,87.3-133.4,131c-10.4,10.3-20.8,20.5-31.2,30.7c-5.5,5.5-14.6,13.7-24.2,14.7c-0.5-1.1-1.2-1.9-1.6-3.3c-1.6-6.8,6.2-12.9,8.8-16.3c12.3-13.4,24.5-26.8,36.8-40.1c34.8-38.1,69.6-76.3,104.4-114.4c9.8-10.8,19.6-21.6,29.5-32.4c3.6-4.5,8.2-8.2,11.3-13.2c1.9-3,3.4-6.6,4.4-10.5c4.5-17.7-5.3-32.9-12.6-42c-3.7-4.6-8.9-8.3-14.1-11.4c-3.2-1.8-6.9-3.2-10.8-4.3c-8.4-2.3-19.5-1.1-26.3,1.6c-7,2.8-11.7,7.3-17.1,11.6c-1.9,1.9-3.8,3.8-5.7,5.7c-5,4.9-10,9.8-15,14.6c-43.7,42.9-87.3,85.8-131,128.6c-7.3,7.2-14.6,14.3-21.8,21.5c-2.1,2.1-4.2,4.3-6.3,6.4c-2.8,2.2-5.3,4.6-8.3,6.7c-4,2.7-10.6,7.7-16.8,7.7c-1.9-6.4,3.7-15.1,6.2-19c1.2-1.8,2.4-3.6,3.6-5.4c3.7-3.7,7.3-7.5,11-11.2c8-8.2,16-16.4,24-24.6c20.7-21.3,41.3-42.7,62-64c11.3-11.6,22.5-23.3,33.8-34.9c3.8-3.9,7.6-7.7,11.4-11.6c3.4-3.5,6.7-7.1,10.1-10.6c2.5-2.5,4.9-5.1,7.3-7.7c2.2-2.3,4.4-4.6,6.6-7c6.4-7.9,14.4-14.4,20.6-22.5c7.4-9.8,8.5-25.6,3.2-38.6c-7.2-17.5-22.9-33.9-48-33.5c-0.8,0.1-1.6,0.1-2.5,0.2c-1.8,0.3-3.5,0.6-5.2,0.8c-5,1.3-9.7,2.9-13.7,5.2c-9.4,5.5-16.8,13-25.2,19.6c-13.1,10.4-24.8,22.5-37.8,33c-4.3,3.9-8.6,7.9-12.9,11.8c-8.6,7.8-17.1,15.6-25.6,23.3c-2.7,2.5-5.4,5-8,7.5c-3.5,3.4-7.1,6.7-10.7,10c-4.4,4.3-8.9,8.5-13.3,12.8c-4.8,4.6-9.5,9.1-14.3,13.7c-1.5,1.5-3,3.1-4.5,4.6c-2.8,2.8-5.7,5.6-8.5,8.4c-2.2,1.8-4,4-6,5.9c-2.3,2.4-4.6,4.7-7,7c-1.3,1.3-2.6,2.6-3.9,3.8c-6.4,6.8-12.9,13.5-19.3,20.3c-2.5,2.8-5,5.5-7.5,8.2c-6.4,7.9-13.5,15.1-19.7,23.2c-3.8,5-7.6,10-11,15.4c-4.3,7-8.1,15.1-11.5,22.8c-4.2,9.5-8.9,18.6-11.8,29.9c-1,3.8-1.1,7.9-1.8,12.2c0,2.1,0,4.1,0,6.2c0.1,1.7,0.1,3.4,0.2,5.1c0.4,3.1,0.9,6.1,1.3,9.2c0.9,4.6,1.5,8.9,3,12.8c5.8,14.9,14.1,25,23.3,36.4c3.3,3.5,6.7,6.9,10,10.3c1.2,1.1,2.3,2.3,3.5,3.4c-7.9,8.1-15.8,16.3-23.7,24.4c-1.1,1.1-2.2,2.2-3.4,3.3C382.7,328.7,278.5,225.6,174.4,122.5c-15.1-15.1-30.2-30.3-47.8-43c-9.8-7-19.9-13.6-31.8-18.6c-8.9-3.6-23.3-7.6-35.9-4.9c-8.2,1.8-14.6,4.7-20.3,9c-6.9,5.2-11.9,12.4-16,20.4c-4.3,8.4-6.6,17.9-8.8,28.7c-0.3,2.9-0.6,5.9-0.9,8.8c0,1.4-0.1,2.9-0.1,4.3c-1,6-1,12.5-2,18.8c-0.1,3.1-0.3,6.1-0.4,9.1c-0.1,3.7-0.3,7.4-0.4,11.1c0,4.1,0,8.1,0,12.2c0.2,5.1,0.4,10.2,0.5,15.4c0.3,3.6,0.6,7.2,0.9,10.8c1.3,7.5,1.8,15.1,3.4,22c1.9,8.3,3.4,16.3,6.5,23.4c5.6,12.9,13.4,24.2,21.1,35.2c11.4,16.1,23.8,31,36,46.4C84,338.1,89.5,344.5,95,351c8.2,10.3,17.9,19.3,26.2,29.5c3,3.3,6,6.5,9.1,9.8c4.4,4.6,8.8,9.2,13.3,13.8c1.6,1.7,3.2,3.3,4.8,5c3.9,4.9,8.8,9.1,13.3,13.5c5.2,5.2,10.2,11.1,15.9,15.7c4.6,4.5,9.3,9,13.9,13.4c3.5,3.2,6.9,6.4,10.4,9.6c9.1,7.3,17.4,15.5,26.8,22.6c8.4,6.4,16.8,12.9,27.3,17.1c7.1,2.8,15.7,3.1,24.1,4.5c2.7,0.2,5.4,0.4,8.1,0.6c4,0.1,7.9,0.2,11.9,0.4c4.2,0,8.5,0,12.7,0c1.4,0,2.8,0,4.2,0c4.5-0.2,8.9-0.4,13.3-0.6c1.5-0.1,3.1-0.1,4.6-0.2c5.1-0.4,10.3-0.9,15.4-1.3c2-0.2,3.9-0.4,5.9-0.5c7.5,8,14.9,15.9,22.4,24C312.2,589.4,245.5,651,178.9,712.6c-31.9,29.7-63.7,59.3-95.6,89c-8.8,8.3-17.7,16.6-26.5,25c-1.3,1.3-2.7,2.7-4,4c-12.3,9.9-19.6,24.9-24,42.7c-6.4,25.3-0.7,54,9.6,70.4c2.4,4,5.3,8.3,8.9,11.2c2.3,1.8,4.3,3.9,6.8,5.6c9.9,7,21.9,11.9,35.4,15.3c3.6,0.9,7.2,1.3,11.1,2c6.8,1.3,19.1,2.2,26.8,0.9c5-0.8,9.8-1.1,14.4-2.3c13.3-3.4,23.4-8.8,32.5-16.2c3-2.4,5.9-5.6,8.3-8.6c3.4-3.6,6.8-7.1,10.2-10.7c7.9-8.3,15.8-16.6,23.7-25c19.7-20.8,39.5-41.6,59.2-62.4c46.9-49.3,93.7-98.6,140.5-147.9c23.7-24.9,47.4-49.9,71.1-74.9c69.5,77.5,139,155,208.4,232.5c18.4,20.6,36.8,41.2,55.1,61.8c6.4,7.2,12.8,14.4,19.2,21.7c2.3,2.6,4.5,5.2,6.8,7.8c1.4,1.9,3,3.9,4.9,5.4c9.4,7.6,18.8,12.3,32.6,15.7c4.6,1.2,9.3,1.1,14.5,1.9c6.3,1,15.6,0.3,21.3-0.7c3.9-0.7,7.4-1,11-2c11.7-3.2,21.7-7.7,30.4-13.8c4.1-2.9,8.7-6.1,11.8-10c2.3-2.8,4.8-5.5,7-8.5c3.9-5.5,6.7-11.7,9.3-18.4c1.9-5,2.6-10.5,3.7-16.2c1.8-9.8,0.5-23.3-1.6-31.6c-4.7-18.9-11.6-33.6-24.5-44c-3.2-3.1-6.3-6.2-9.5-9.2c-6.2-6.1-12.4-12.2-18.6-18.3C772.9,711.4,677,618.3,581.1,525.3c10.3-12,20.7-24,31-36c1-0.7,4.8,2.5,6.2,3.5c6,4.2,12.4,8.2,18.8,12c12.6,7.5,26.5,13,42.3,17.4c6.6,1.9,16,3.6,24.1,1.8c4.9-1.1,9.4-2.2,13.7-3.9c23.7-9.5,41.9-25.2,60.4-39.9c4.6-4,9.2-7.9,13.7-11.9c5.5-5.1,11-10.2,16.6-15.4c2.6-2.5,5.2-5,7.9-7.5c6.3-5,12.2-11.9,17.9-17.6c4.5-4.5,9.5-8.8,13.4-13.7c1.7-1.7,3.3-3.4,5-5.1c3.1-3.2,6.1-6.5,9.2-9.7c7-7.4,14-14.9,21-22.3c4.5-5,9.1-10,13.6-15c3.8-4.3,7.7-8.6,11.5-12.9c10.3-12.8,22.1-24.3,32.3-37.2c2.3-2.7,4.7-5.4,7-8c8.5-10.2,17.1-20.4,25.6-30.6c4.6-5.8,11.7-12.2,14.8-19.2C992.3,242.4,989.9,229.6,984.4,220.3z M931.7,259.2c-10.1,11.9-20.2,23.7-30.3,35.6c-9.9,11.3-19.7,22.5-29.6,33.7c-3.5,4-7.1,7.9-10.7,11.9c-4.2,4.6-8.5,9.3-12.7,13.9c-6.3,6.6-12.5,13.2-18.7,19.8c-2.7,2.8-5.4,5.7-8.2,8.5c-1.9,2.1-4,4.1-6,6.1c-4,4.1-8.1,8.2-12.2,12.3c-4.6,4.6-9,9.8-14.2,13.9c-2.7,2.6-5.4,5.2-8.1,7.8c-4,3.2-7.3,7.3-11.3,10.5c-4.3,3.9-8.6,7.8-12.9,11.6c-12.9,10.3-25.1,21-39.5,30c-4.9,3.1-9.9,6-15.9,8.1c-1.8,0.6-4.5,1.9-7.1,1.4c-26.8-5.1-48.5-20.7-66.5-34.9c-6.4-6-12.8-12-19.2-17.9c-27.6,32-55.1,64-82.8,96c-0.1,0.1-0.1,0.1-0.2,0.2c97.2,94.4,194.5,188.8,291.8,283.1c13.5,13.2,27,26.3,40.5,39.5c3,2.9,6,5.8,9.1,8.8c2.7,2.6,5.3,5.2,8,7.8c1.8,2.4,3.2,5.5,4.3,8.4c6.7,17,4.5,40-7.4,49.6c-10.9,8.8-29,15.9-49.2,11.2c-3.9-0.9-7.9-2.1-11.1-3.9c-3.2-1.9-5.4-5-7.6-7.8c-4-4.6-8-9.2-12.2-13.8c-13.8-15.5-27.6-31-41.4-46.6C686.9,793,623.2,721.9,559.4,650.9c-17.3-19.3-34.6-38.5-51.8-57.8c-4.8-5.4-9.7-10.8-14.5-16.2c-1-1.2-3.9-5.2-5.2-5.7c-98.8,104.2-197.6,208.4-296.4,312.6c-10.2,10.7-20.4,21.3-30.5,32c-2.3,2.4-4.5,4.8-6.8,7.1c-4.5,5.6-9.5,10.1-16.9,12.9c-16.6,6.4-39.1,1.8-52.3-4c-3.7-1.6-8.1-3.8-10.5-6.8c-9-11.2-10-35-4-50.6c3.1-8.1,8.2-13.7,14.4-18.7c2.9-2.7,5.8-5.5,8.7-8.2c12.7-12,25.5-24,38.2-36c16.1-14.9,32.2-29.9,48.2-44.9c57.1-52.8,114.2-105.6,171.2-158.3c28.2-26.1,56.5-52.1,84.7-78.2c0-0.1,0-0.1,0-0.2c-21.2-22.7-42.4-45.4-63.6-68.1c-3.7,0-6.8,0.5-10.1,1.1c-2.9,0.4-5.9,0.7-8.8,1c-8.6,0.7-17.1,1.3-25.7,2c-2.7,0.1-5.5,0.2-8.2,0.3c-2.3,0.1-4.6,0.1-6.9,0.2c-4.1,0-8.2,0-12.2,0c-2.6-0.1-5.2-0.1-7.9-0.2c-7.8-1.2-15.7-0.7-22.5-2.9c-2-0.6-3.6-2-5.3-3c-5.1-3.2-9.5-7-14.2-10.5c-7.9-6.1-14.9-13.1-22.5-19.3c-3.1-2.8-6.2-5.7-9.4-8.6c-3.6-3.5-7.2-7-10.9-10.5c-4-4-8.1-7.9-12.1-11.9c-3.3-3.4-6.7-6.8-10-10.2c-2.4-2.4-4.9-4.9-7.3-7.3c-6.4-6.8-12.8-13.6-19.2-20.4c-2.3-2.5-4.7-5-7-7.4c-6.9-7.7-13.9-15.4-20.8-23.1c-6.6-7.6-13.2-15.3-19.7-22.9c-13.2-16.7-26.8-33-39.3-50.7c-5.3-7.5-10.7-15.6-14.2-24.6c-2.5-6.5-3.3-14-4.7-21.5c-1.1-5.2-1.2-10.9-2-16.4c-0.2-2.3-0.3-4.6-0.5-6.9c-0.1-3.6-0.2-7.1-0.3-10.7c0-3.2,0-6.4,0-9.6c0.1-3.7,0.3-7.5,0.4-11.2c0.1-2.1,0.2-4.1,0.3-6.2c0.8-5.4,0.7-11.1,1.6-16.3c0.6-3.4,0.2-7.4,0.8-11c1.6-9.8,3.4-22,10.1-26.5c2.7-1.8,8-1.1,11.2-0.2c8.7,2.6,15.7,7,22.5,11.5c16.6,11.1,30.7,25,44.5,38.9c10.5,10.4,21,20.8,31.4,31.3c104.7,103.6,209.4,207.2,314,310.8c0.1,0,0.1,0,0.2,0c28.8-29.5,57.5-59.1,86.3-88.6c-6-4.5-11.9-9-17.8-13.5c-9.3-7-19.1-15.6-26.3-24.7c-5.2-6.5-10.8-12.5-14.1-20.9c-1.6-4-1.7-8.9-2.5-13.8c0.1-1.9,0.1-3.9,0.2-5.9c1.4-8.7,4.2-14.5,7.2-21.2c2-4.1,4-8.2,6-12.4c2.4-5.3,5-10.7,8.1-15.2c6.1-8.6,13.1-16.1,19.6-24.1c6.2-7.7,13.8-14.2,20-21.9c2.2-2.3,4.4-4.6,6.7-6.9c2.7-2.7,5.4-5.4,8-8c2.6-2.6,5.2-5.2,7.8-7.9c2.7-2.6,5.3-5.3,8-7.9c1.4-1.5,2.9-3,4.4-4.5c4.6-4.4,9.2-8.8,13.7-13.2c5.4-5.3,10.8-10.5,16.3-15.7c4.1-3.9,8.3-7.8,12.4-11.7c3.2-2.9,6.3-5.9,9.4-8.8c9.8-8.9,19.6-17.8,29.4-26.7c3.5-3.3,7.1-6.5,10.7-9.8c11.3-9.1,21.4-19.5,32.7-28.5c6.3-5,11.9-11.2,19-15.4c1-0.4,2.1-0.7,3.1-1.1c4.4,0,8.7,5.7,9.3,9.4c-3.2,4.6-8,8.1-11.5,12.4c-9.1,9.7-18.3,19.3-27.4,29c-2.2,2.3-4.4,4.5-6.7,6.8c-21.7,22.4-43.3,44.9-64.9,67.3c-6.4,6.6-12.9,13.2-19.3,19.8c-8.1,8.3-16.2,16.6-24.3,25c-9.6,9.8-19.1,19.5-28.7,29.2c-8.4,10.5-15.4,22-19.2,37.1c-2.4,9.4-1.4,21.8,1.8,29.3c2.8,6.6,7.4,12.6,12.8,16.7c3.8,2.9,8.2,5.3,13.4,6.9c21.6,6.6,44-7.7,55.8-16.4c6.7-5,12.3-11.2,18.2-17c6.4-6.2,12.7-12.4,19-18.6c3.5-3.5,7-7,10.5-10.5c30.8-30.3,61.6-60.6,92.4-90.9c12.5-12.2,24.9-24.3,37.4-36.5c3.4-3.4,6.9-6.7,10.3-10.1c1.4-1.4,3.1-3.8,5.2-4.3c3.6-0.9,7.9,6.3,8.9,8.9c-13.1,14.3-26.1,28.6-39.1,43c-33.2,36.3-66.4,72.7-99.5,109.1c-8.6,9.3-17.2,18.6-25.8,28c-6,7.5-13.5,13.7-19.3,21.4c-3.8,5.1-6.6,10.5-9.1,16.9c-2.4,6.1-4.5,15.5-2.8,23.9c0.6,3.2,1.2,6.3,2.3,9c2.4,6.3,5.9,11.2,9.8,16.1c2.9,3.6,7.6,7.1,12.1,9c2.9,1.3,6,2.3,9.5,3.1c6.8,1.5,15.4,0.5,21.1-1.2c14.2-4.2,24.4-11.2,34.5-19.3c62.5-61.4,125-122.9,187.5-184.3c7.4,0,15.5,5.6,18.7,9.9C942.8,245.8,937.3,252.5,931.7,259.2z"/></g>-->
<!--</svg>-->


            <div><div class="">
              <div class="whitespace-nowrap text-sm text-gray-500 mb-0.5 font-semibold">Calorie Intake:</div>
              <div class="max-w-lg flex rounded-md shadow-sm">
                <input
                  @input="updateSchedule"
                  type="number" v-model="scheduleData.calorieIntake[activeDay.id -1]" name="calorie intake"
                  class="text-large flex-1 block w-full focus:ring-indigo-500 focus:border-indigo-500 min-w-0 rounded-none rounded-l-md border-gray-300">
                <span
                  class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
                  kcal
                </span>
              </div>
            </div>

            <div class="flex space-x-1 items-center mt-2">
              <div>
                <svg xmlns="http://www.w3.org/2000/svg" class="text-gray-500 h-5 w-5" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" stroke-width="1.5">
                  <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
                </svg>
              </div>
              <div>
                <div class=" text-base">
                  <span class="font-semibold text-gray-900">1700</span><span class="text-sm text-gray-500"> ckal deficit for weight loss</span>
                </div>

              </div>
            </div>
          </div>
        </div>
        </div>
        <transition-group tag="div" name="list" class="mt-2 space-y-2">
          <div v-for="(workout, index) in activeDay.events" :key="index"
               @click="isEventDetailsModalOpen = true; selectedEvent = workout"
               class="border-l-4 border-gray-300 bg-gray-100 w-full rounded-md py-3 text-gray-600 flex space-x-2 items-center px-2">
            <div>
              <svg xmlns="http://www.w3.org/2000/svg" class="h-10 h-10" fill="none" viewBox="0 0 24 24"
                   stroke="currentColor" stroke-width="1.6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
              </svg>
            </div>
            <div>
              <div class="text-gray-800 font-semibold text-sm">{{ workout.name }}</div>
              <div class="text-sm text-gray-500 tex-xs">
                <!--              <span v-for="data in workout.data">{{ data }}</span> -->
                <span class="text-gray-800 font-semibold">1</span>&nbsp;km | <span class="text-gray-800 font-semibold">20</span>&nbsp;minutes
              </div>
            </div>
            <!--            <div @click="destroyEvent(workout, activeDay.id)" class="cursor-pointer">-->
            <!--              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"-->
            <!--                   stroke="currentColor" stroke-width="2">-->
            <!--                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>-->
            <!--              </svg>-->
            <!--            </div>-->
          </div>
        </transition-group>


      </div>

      <!--   TODO: Seperate Route  -->
      <button
        @click="toggleAddWorkoutModal(true)"
        type="button"
        class="absolute bottom-4 right-4 rounded-md bg-indigo-600 p-3.5 text-white shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
             stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
      </button>
    </swipe-modal>



    <modal v-if="isEventDetailsModalOpen" @close-modal="isEventDetailsModalOpen = false">
      <template v-slot:header>
        {{ selectedEvent.name }}
      </template>
      <template v-slot:footer>
        <button
          @click="destroyEvent(selectedEvent)"
          type="button"
          class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 col-start-2 sm:text-sm">
          Delete Workout Event
        </button>
      </template>
    </modal>


    <!--    <div-->
    <full-page-modal v-if="isEventModalOpen" @close-modal="isEventModalOpen = false">
      <template v-slot:header>
        Add Workout
      </template>
      <template v-slot:footer>
        <div class="grid grid-cols-2 gap-3 grid-flow-row-dense">
          <button
            @click="submitEvent($refs['select-workout'].value, $refs['select-weekday'].value)"
            type="button"
            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 col-start-2 sm:text-sm">
            Add Workout
          </button>
          <button
            @click="toggleAddWorkoutModal"
            type="button"
            class="w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mt-0 col-start-1 sm:text-sm">
            Cancel
          </button>
        </div>
      </template>

      <div class="flex flex-col flex-grow justify-between mt-3">
        <div class="mt-1 relative space-y-4">
          <div>
            <label for="select-weekday" class="block text-sm font-medium text-gray-700">Day of the
              week</label>
            <select
              ref="select-weekday"
              id="select-weekday" name="select-weekday"
              :value="activeDay.id"
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
          <div class="flex justify-center">
            <Link href="/workouts"
                  class="mt-3 border border-indigo-600 rounded-md py-2 px-6 w-max text-base flex items-center space-x-2 text-indigo-600 text-center justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                      d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                      clip-rule="evenodd"/>
              </svg>
              <div
                type="button"
                class="font-medium">
                Create new workout
              </div>
            </Link>
          </div>
        </div>
      </div>
    </full-page-modal>
    <!--      v-if="isEventModalOpen" class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">-->
    <!--      <div @click="toggleAddWorkoutModal(false)"-->
    <!--           class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>-->
    <!--      <div class="fixed z-10 inset-0 overflow-y-auto pointer-events-none">-->
    <!--        <div class="flex items-center justify-center min-h-full text-center sm:p-0">-->
    <!--          <div-->
    <!--            class="flex flex-col pointer-events-auto w-screen h-screen	relative z-10 bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all  max-w-lg w-full">-->
    <!--            <div class="relative text-center">-->
    <!--              <div class="absolute">-->
    <!--                <svg-->
    <!--                  @click="toggleAddWorkoutModal"-->
    <!--                  xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"-->
    <!--                  stroke="currentColor" stroke-width="2">-->
    <!--                  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>-->
    <!--                </svg>-->
    <!--              </div>-->
    <!--              <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Add Workout</h3>-->
    <!--            </div>-->
    <!--            <div class="flex flex-col flex-grow mt-3">-->

    <!--              <div class="flex flex-col flex-grow mt-2">-->
    <!--                &lt;!&ndash; This example requires Tailwind CSS v2.0+ &ndash;&gt;-->
    <!--      -->
    <!--              </div>-->
    <!--              <div class="mt-5 grid grid-cols-2 gap-3 grid-flow-row-dense">-->
    <!--                <button-->
    <!--                  @click="submitEvent($refs['select-workout'].value, $refs['select-weekday'].value)"-->
    <!--                  type="button"-->
    <!--                  class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 col-start-2 sm:text-sm">-->
    <!--                  Add Workout-->
    <!--                </button>-->
    <!--                <button-->
    <!--                  @click="toggleAddWorkoutModal"-->
    <!--                  type="button"-->
    <!--                  class="w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mt-0 col-start-1 sm:text-sm">-->
    <!--                  Cancel-->
    <!--                </button>-->
    <!--              </div>-->
    <!--            </div>-->

    <!--          </div>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--    </div>-->

  </div>
</template>

<script>

import BodyLayout from '@/Shared/BodyLayout'
import SwipeModal from "../../Shared/SwipeModal";
import {getCurrentInstance} from "vue";

import axios from 'axios';
import {Link} from '@inertiajs/inertia-vue3'
import FullPageModal from "@/Shared/FullPageModal";
import Modal from "@/Shared/Modal";

export default {
  layout: BodyLayout,
  props: ['workouts', 'workoutEvents', 'bodies', 'schedule'],
  components: {FullPageModal, SwipeModal, Link, Modal},
  data() {
    return {
      modal: false,
      scheduleData: this.schedule,
      isEventModalOpen: false,
      isEventDetailsModalOpen: false,
      selectedEvent: null,
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
  created() {

  },
  mounted() {
    this.modal = true;
    this.setWorkoutEvents();
  },
  methods: {
    setWorkoutEvents(){
      console.log('setWorkoutEvents');
      this.sharedState.forEach(state => state.events = []);
      this.workoutEvents.forEach(workoutEvent => {
        this.sharedState[workoutEvent.day_id - 1].events.push({
          ...workoutEvent,
          edit: false,
        });
      });

      this.sharedState.map((day, index) => {
        day.calorieIntake = this.schedule.calorieIntake[index];
      });
    },
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
          console.log('res', res);
          this.toggleAddWorkoutModal(false);
          // const activeDay = this.sharedState[dayId - 1];
          //
          // let workout = this.workouts.find((workout) => workout.id == eventDetails);
          // activeDay.events.push({
          //   ...workout,
          //   edit: false,
          //   id: res.data.id,
          // });
          this.$inertia.reload();

          this.$nextTick(() => {
            console.log('next tick', this.workoutEvents);
            this.setWorkoutEvents();
          });
        });
    },
    destroyEvent(workout) {
      axios.delete('/workout-events/' + workout.id, workout, {
        headers: {
          'Content-Type': 'application/json',
        },
      })
        .then(res => {
          // const activeDay = this.sharedState[workout.day_id - 1];
          // let eventIndex = activeDay.events.findIndex((element) => element.id == workout.id);
          this.isEventDetailsModalOpen = false;
          // console.log('activeDay', activeDay);
          // console.log('eventIndex', eventIndex);
          //
          // activeDay.events.splice(eventIndex, 1);
          this.$inertia.reload();

          this.$nextTick(() => {
            console.log('next tick', this.workoutEvents);

            this.setWorkoutEvents();
          });
        });
    },
    bodyOnchange() {
      this.updateSchedule();
    },
    updateSchedule() {
      console.log('updateSchedule');
      const data = {
        body_id: this.schedule.body.id,
        weeks: this.scheduleData.weeks,
        mon_calorie_intake: this.scheduleData.calorieIntake[0],
        tue_calorie_intake: this.scheduleData.calorieIntake[1],
        wed_calorie_intake: this.scheduleData.calorieIntake[2],
        thu_calorie_intake: this.scheduleData.calorieIntake[3],
        fri_calorie_intake: this.scheduleData.calorieIntake[4],
        sat_calorie_intake: this.scheduleData.calorieIntake[5],
        sun_calorie_intake: this.scheduleData.calorieIntake[6],
      }

      axios.put('/schedules/' + this.schedule.id, data, {
        headers: {
          'Content-Type': 'application/json',
        },
      })
        .then(res => {
          this.$inertia.reload({only: ['newBody']});

          this.$inertia.reload();

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
    formatNumber(number) {
      return Number((number).toFixed(1)).toLocaleString();
    }
  },
  computed: {
    activeDayCaloriesBurnt() {
      let workoutCaloriesBurnt = this.activeDay.events.map((event) => {
        return event.data.calories_burnt;
      })

      if (!workoutCaloriesBurnt.length) {
        return this.activeDay.calorieIntake;
      }

      return (workoutCaloriesBurnt.reduce((prev, calories_burnt) => {
        return prev + calories_burnt;
      }) - this.activeDay.calorieIntake);
    },
    activeDay() {
      return this.sharedState.find((day) => day.active);
    }
  }
}

</script>

<style>

</style>
