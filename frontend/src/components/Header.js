import React from 'react'

const Header = () => {

  
  // const observer = new IntersectionObserver(entries => {
  //   // Loop over the entries
  //   entries.forEach(entry => {
  //     // If the element is visible
  //     if (entry.isIntersecting) {
  //       // Add the animation class
  //       entry.target.classList.add('star-animation');
  //     }
  //   });
  // })
  
  // observer.observe(document.querySelector('.star-container'));

  return (
    <div className='w-full h-[700px] bg-[#AE0B05] text-white relative top-[80px]'>
        <div className='h-full flex flex-col justify-center z-10'>
            <h2 className='lg:mx-30 md:mx-20 mx-10 font-black lg:text-[4rem] uppercase md:text-[2rem] text-[1.3rem]'>
            The community of 2337 free, open and local programming clubs for young people
            </h2>
            <p className='mx-10 md:mx-20 lg:mx-30 lg:text-[1.2rem] pt-5'>
            58,000 young people are being creative with technology with the help of 12,000 volunteers in 115 countries. Join us!
            </p>
            <div className='flex justify-center items-center lg:mt-32 mt-20'>
            <button className='bg-black w-[300px] z-10 h-[70px] text-center font-bold uppercase  rounded-[50px]'>
                <a href="/signup">Become a ninja now!</a>
            </button>
            </div>
            <div className='star-container  w-full h-full absolute z-0 group overflow-hidden'>
            <svg className="animate relative text-xl left-[-80px] group-hover:left-[2000px] duration-1000">
              <g>
	              <path d="M51.7,36.1c0-5.8,4.4-10.6,10.1-11.3L67.9,4l-20.7,6.1c-0.6,5.7-5.4,10.1-11.3,10.1c-5.8,0-10.6-4.4-11.3-10.1L3.9,4
		            l6.1,20.8C15.6,25.4,20,30.2,20,36.1S15.6,46.7,9.9,47.3L3.9,68L24.6,62c0.6-5.7,5.4-10.1,11.3-10.1c5.8,0,10.6,4.4,11.3,10.1
	            	L67.9,68l-6.1-20.7C56.1,46.7,51.7,41.9,51.7,36.1z M35.9,40.6c-2.5,0-4.5-2-4.5-4.5c0-2.5,2-4.5,4.5-4.5c2.5,0,4.5,2,4.5,4.5
		            C40.4,38.5,38.4,40.6,35.9,40.6z"/>
              </g>
            </svg>
            <svg className=" animate relative text-xl left-[-80px] group-hover:left-full duration-500">
              <g>
	              <path d="M51.7,36.1c0-5.8,4.4-10.6,10.1-11.3L67.9,4l-20.7,6.1c-0.6,5.7-5.4,10.1-11.3,10.1c-5.8,0-10.6-4.4-11.3-10.1L3.9,4
		            l6.1,20.8C15.6,25.4,20,30.2,20,36.1S15.6,46.7,9.9,47.3L3.9,68L24.6,62c0.6-5.7,5.4-10.1,11.3-10.1c5.8,0,10.6,4.4,11.3,10.1
	            	L67.9,68l-6.1-20.7C56.1,46.7,51.7,41.9,51.7,36.1z M35.9,40.6c-2.5,0-4.5-2-4.5-4.5c0-2.5,2-4.5,4.5-4.5c2.5,0,4.5,2,4.5,4.5
		            C40.4,38.5,38.4,40.6,35.9,40.6z"/>
              </g>
            </svg>
            <svg className="animate relative text-xl left-[-80px] group-hover:left-full duration-700">
              <g>
	              <path d="M51.7,36.1c0-5.8,4.4-10.6,10.1-11.3L67.9,4l-20.7,6.1c-0.6,5.7-5.4,10.1-11.3,10.1c-5.8,0-10.6-4.4-11.3-10.1L3.9,4
		            l6.1,20.8C15.6,25.4,20,30.2,20,36.1S15.6,46.7,9.9,47.3L3.9,68L24.6,62c0.6-5.7,5.4-10.1,11.3-10.1c5.8,0,10.6,4.4,11.3,10.1
	            	L67.9,68l-6.1-20.7C56.1,46.7,51.7,41.9,51.7,36.1z M35.9,40.6c-2.5,0-4.5-2-4.5-4.5c0-2.5,2-4.5,4.5-4.5c2.5,0,4.5,2,4.5,4.5
		            C40.4,38.5,38.4,40.6,35.9,40.6z"/>
              </g>
            </svg>
            </div>
        </div>
    </div>
  )
}

export default Header