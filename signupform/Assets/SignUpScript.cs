using UnityEngine;
using UnityEngine.Networking;
using UnityEngine.UI;
using System;
using System.Collections;
using TMPro;

[System.Serializable]
public class SignUpData
{
    public string email;
    public string password;
    public string createDate;

    public SignUpData(string email, string password)
    {
        this.email = email;
        this.password = password;
        this.createDate = DateTime.Now.ToString("yyyy-MM-ddTHH:mm:ss");
    }
}

public class SignUpScript: MonoBehaviour
{
    public TMP_InputField emailField;
    public TMP_InputField passwordField;
    public TMP_InputField reenterField;
    public string email, password, reenter;

    void Start()
    {
        emailField.onValueChanged.AddListener((value) => OnInputFieldValueChanged("Email", value));
        passwordField.onValueChanged.AddListener((value) => OnInputFieldValueChanged("Password", value));
        reenterField.onValueChanged.AddListener((value) => OnInputFieldValueChanged("Re-enter", value));
    }

    //DEBUG
    void OnInputFieldValueChanged(string fieldName, string value)
    {
        Debug.Log($"{fieldName} input text changed: {value}");
        if (fieldName == "Email")
        {
            email = value;
        }
        if (fieldName == "Password")
        {
            password = value;
        }
        if (fieldName == "Re-enter")
        {
            reenter = value;
            //check if reenter = password
            if (reenter != password)
            {
                Debug.Log("Password doesn't match!");
            }
        }
    }

    public void SubmitSignup()
    {
        // Optional: Validate fields before submitting
        if (string.IsNullOrEmpty(email) || string.IsNullOrEmpty(password) || string.IsNullOrEmpty(reenter))
        {
            Debug.LogWarning("All fields must be filled!");
            return;
        }
        if (password != reenter)
        {
            Debug.LogWarning("Passwords do not match!");
            return;
        }

        // Create the data object
        SignUpData data = new SignUpData(email, password);

        // Submit to SignupHandler
        HandleSignup(data);

        // Optionally, send the signup request to the server
        SendSignUpRequest(email, password);
        PostSignUpData(email, password);
    }



    //signuphandling
    public static void HandleSignup(SignUpData data)
    {
        // Here you would process the signup data
        Debug.Log($"SignupHandler received: {data.email}, {data.password}, {data.createDate}");
        // For example, you could call your API here, or do further validation
    }


    private const string API_URL = "https://binusgat.rf.gd/unity-api-test/api/auth/signup.php";

    public static SignUpScript Instance;

    void Awake()
    {
        if (Instance == null)
        {
            Instance = this;
            DontDestroyOnLoad(gameObject);
        }
        else
        {
            Destroy(gameObject);
        }
    }

    public void SendSignUpRequest(string email, string password)
    {
        StartCoroutine(PostSignUpData(email, password));
    }

    private IEnumerator PostSignUpData(string email, string password)
    {
        SignUpData formData = new SignUpData(email, password);
        string jsonData = JsonUtility.ToJson(formData);

        using (UnityWebRequest request = new UnityWebRequest(API_URL, "POST"))
        {
            byte[] bodyRaw = System.Text.Encoding.UTF8.GetBytes(jsonData);

            request.uploadHandler = new UploadHandlerRaw(bodyRaw);
            request.downloadHandler = new DownloadHandlerBuffer();
            request.SetRequestHeader("Content-Type", "application/json");

            yield return request.SendWebRequest();

            if (request.result != UnityWebRequest.Result.Success)
            {
                Debug.LogError($"Error: {request.error}");
                // Handle network error
            }
            else
            {
                Debug.Log($"Response: {request.downloadHandler.text}");
                // Process server response
            }
        }
    }
}
