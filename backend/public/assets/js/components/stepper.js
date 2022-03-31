class stepper {
  constructor() {
    let currentStep = 0;
    const interval = setInterval(function () {
      if (document.getElementsByClassName("stepper")[0] !== undefined) {
        clearInterval(interval);
        var stepperHeader = document.getElementById("stepperHeader");
        let stepperButtons = stepperHeader.querySelectorAll("li");

        for (let i = 0; i < stepperButtons.length; i++) {
          updateStep(i);
        }

        function updateStep(index) {
          let parent = stepperButtons[index].parentNode;
          let futureStep = Array.from(parent.children).indexOf(
            stepperButtons[index]
          );
          var stepperHeader = document.getElementById("stepperHeader");
          var stepsButton = stepperHeader.querySelectorAll("li")[index];
          stepsButton.addEventListener("click", function () {
            currentStep = futureStep;
            console.log(currentStep);
          });
        }
      }
    }, 100);
  }

  nextStep(currentStep) {
    currentStep++;
    var stepperContent = document.getElementById("stepperContent");
    var steps = stepperContent.querySelectorAll(".step");
    steps.forEach((step) => {
      //step.style.transform = `translateX(-${stepIndex}00%)`;
      anime({
        targets: step,
        translateX: `${currentStep}00%`,
      });
    });
  }
  prevStep(currentStep) {
    currentStep--;
    var stepperContent = document.getElementById("stepperContent");
    var steps = stepperContent.querySelectorAll(".step");
    steps.forEach((step) => {
      //step.style.transform = `translateX(-${stepIndex}00%)`;
      anime({
        targets: step,
        translateX: `${currentStep}00%`,
      });
    });
  }
  customStep(currentStep, futureStep) {
    currentStep = futureStep;
    var stepperContent = document.getElementById("stepperContent");
    var steps = stepperContent.querySelectorAll(".step");
    steps.forEach((step) => {
      //step.style.transform = `translateX(-${stepIndex}00%)`;
      anime({
        targets: step,
        translateX: `${currentStep}00%`,
      });
    });
  }
}
export default stepper;
